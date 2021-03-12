FROM php:7.4-apache

# Args
ARG PUID=1000
ARG PGID=1000

# Install packages
RUN apt-get update \
    && apt-get install -y \
        cron \
        nodejs \
        npm \
        git \
        unzip \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create dirs and move files
RUN mkdir -p /var/www
WORKDIR /var/www
COPY --chown=www-data:www-data . .

COPY .env.docker .env

# Install dependencies
RUN \
    echo "Installing Composer dependencies...\n" \
    && composer install \
        --ignore-platform-reqs \
        --no-interaction \
        --no-plugins \
        --no-scripts \
        --prefer-dist \
    && echo "Installing Node dependencies...\n" \
    && npm install \
    && echo "Running migrations...\n" \
    && npm run production

# Configure Apache
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Install scheduler to cron
RUN CRONFILE=/etc/cron.d/scheduler && \
    mkdir -p /etc/cron.d && \
    touch $CRONFILE && \
    echo "* * * * * cd ${PWD} && php artisan schedule:run" >> $CRONFILE && \
    chmod 0644 $CRONFILE && \
    crontab $CRONFILE

# Create database if it doesn't exist
RUN mkdir -p /var/www/storage && \
    touch /var/www/storage/db.sqlite && \
    chown www-data:www-data /var/www/storage/db.sqlite

# Run
VOLUME [ "/games", "/var/www/storage" ]

RUN chmod +x /var/www/docker-entrypoint.sh
ENTRYPOINT [ "/var/www/docker-entrypoint.sh" ]
