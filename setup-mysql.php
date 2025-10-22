<?php
/**
 * MySQL Setup Script for KPI Management System
 * 
 * This script helps you set up the MySQL database configuration
 */

echo "=== KPI Management System - MySQL Setup ===\n\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "❌ .env file not found. Creating from template...\n";
    
    $envContent = 'APP_NAME="KPI Management System"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=kpicursor
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"';

    file_put_contents('.env', $envContent);
    echo "✅ .env file created successfully!\n\n";
} else {
    echo "✅ .env file found.\n\n";
}

// Check MySQL connection
echo "Testing MySQL connection...\n";

try {
    $pdo = new PDO('mysql:host=localhost;port=3306', 'root', '');
    echo "✅ MySQL connection successful!\n";
    
    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE 'kpicursor'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Database 'kpicursor' already exists.\n";
    } else {
        echo "⚠️  Database 'kpicursor' not found. Creating...\n";
        $pdo->exec("CREATE DATABASE kpicursor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "✅ Database 'kpicursor' created successfully!\n";
    }
    
} catch (PDOException $e) {
    echo "❌ MySQL connection failed: " . $e->getMessage() . "\n";
    echo "\nPlease ensure:\n";
    echo "1. MySQL server is running\n";
    echo "2. Root user has no password (or update the script)\n";
    echo "3. PHP MySQL extension is installed\n";
    exit(1);
}

echo "\n=== Setup Complete ===\n";
echo "Next steps:\n";
echo "1. Run: php artisan key:generate\n";
echo "2. Run: php artisan migrate:fresh --seed\n"; 
echo "3. Run: php artisan serve\n";
echo "4. Open: http://localhost:8000\n";
echo "5. Login with: test@example.com / password\n\n";

echo "Happy KPI tracking! 📊\n";
 