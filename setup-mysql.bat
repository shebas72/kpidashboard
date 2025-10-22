@echo off
echo ========================================
echo KPI Management System - MySQL Setup
echo ========================================
echo.

echo Creating .env file...
if not exist .env (
    echo APP_NAME="KPI Management System" > .env
    echo APP_ENV=local >> .env
    echo APP_KEY= >> .env
    echo APP_DEBUG=true >> .env
    echo APP_TIMEZONE=UTC >> .env
    echo APP_URL=http://localhost:8000 >> .env
    echo. >> .env
    echo DB_CONNECTION=mysql >> .env
    echo DB_HOST=localhost >> .env
    echo DB_PORT=3306 >> .env
    echo DB_DATABASE=kpicursor >> .env
    echo DB_USERNAME=root >> .env
    echo DB_PASSWORD= >> .env
    echo. >> .env
    echo SESSION_DRIVER=database >> .env
    echo SESSION_LIFETIME=120 >> .env
    echo SESSION_ENCRYPT=false >> .env
    echo SESSION_PATH=/ >> .env
    echo SESSION_DOMAIN=null >> .env
    echo. >> .env
    echo BROADCAST_CONNECTION=log >> .env
    echo FILESYSTEM_DISK=local >> .env
    echo QUEUE_CONNECTION=database >> .env
    echo. >> .env
    echo CACHE_STORE=database >> .env
    echo CACHE_PREFIX= >> .env
    echo. >> .env
    echo LOG_CHANNEL=stack >> .env
    echo LOG_STACK=single >> .env
    echo LOG_DEPRECATIONS_CHANNEL=null >> .env
    echo LOG_LEVEL=debug >> .env
    echo. >> .env
    echo MAIL_MAILER=log >> .env
    echo MAIL_HOST=127.0.0.1 >> .env
    echo MAIL_PORT=2525 >> .env
    echo MAIL_USERNAME=null >> .env
    echo MAIL_PASSWORD=null >> .env
    echo MAIL_ENCRYPTION=null >> .env
    echo MAIL_FROM_ADDRESS="hello@example.com" >> .env
    echo MAIL_FROM_NAME="${APP_NAME}" >> .env
    echo. >> .env
    echo VITE_APP_NAME="${APP_NAME}" >> .env
    echo .env file created successfully!
) else (
    echo .env file already exists.
)

echo.
echo Generating application key...
php artisan key:generate

echo.
echo Running database migrations and seeders...
php artisan migrate:fresh --seed

echo.
echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo To start the application:
echo 1. Run: php artisan serve
echo 2. Open: http://localhost:8000
echo 3. Login with: test@example.com / password
echo.
echo Happy KPI tracking! 📊
pause
