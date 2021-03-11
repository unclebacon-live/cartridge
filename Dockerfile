FROM php:7.4-cli

# Args
ARG PUID=1000
ARG PGID=1000

# Install packages
RUN apt-get update \
    && apt-get install -y \
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
RUN mkdir -p /app

WORKDIR /app
COPY . .

COPY config.default.json config.json
COPY .env.docker .env

# Install dependencies
RUN \
    echo "Installing Composer dependencies..." \
    && composer install \
        --ignore-platform-reqs \
        --no-interaction \
        --no-plugins \
        --no-scripts \
        --prefer-dist \
    && echo "Installing Node dependencies..." \
    && npm install \
    && echo "Running migrations..." \
    && npm run production

# Ensure DB exists
RUN mkdir -p /data && \
    touch /data/db.sqlite

# Run
VOLUME [ "/games", "/app/storage" ]
EXPOSE 8000

RUN chmod +x /app/docker-start.sh
ENTRYPOINT [ "/app/docker-start.sh" ]
