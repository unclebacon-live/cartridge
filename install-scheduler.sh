echo "Adding Laravel scheduler to CRON..."
crontab -l | { cat; echo "* * * * * cd ${PWD} && php artisan schedule:run >> /dev/null 2>&1"; } | crontab -
echo "Done!"