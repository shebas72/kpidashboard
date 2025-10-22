# MySQL Database Setup for KPI Management System

## Prerequisites
- MySQL server running on localhost
- MySQL root access
- PHP with MySQL extension (pdo_mysql)

## Step 1: Create the Database

Connect to MySQL and create the database:

```sql
CREATE DATABASE kpicursor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Step 2: Configure Environment Variables

Create or update your `.env` file in the project root with the following MySQL configuration:

```env
APP_NAME="KPI Management System"
APP_ENV=local
APP_KEY=base64:your-app-key-here
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:8000

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

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

## Step 3: Generate Application Key

Run the following command to generate a new application key:

```bash
php artisan key:generate
```

## Step 4: Run Migrations and Seeders

```bash
php artisan migrate:fresh --seed
```

## Step 5: Start the Application

```bash
php artisan serve
```

## Database Schema

The system will create the following tables:

1. **users** - User authentication and profile data
2. **kpi_categories** - KPI category definitions
3. **kpis** - Key Performance Indicators
4. **kpi_data** - Historical KPI data points
5. **migrations** - Laravel migration tracking
6. **cache** - Application cache
7. **jobs** - Queue job tracking
8. **sessions** - User session data

## Default Data

The seeder will create:
- 1 test user (test@example.com / password)
- 6 KPI categories with different colors

## Troubleshooting

### Connection Issues
- Ensure MySQL is running
- Check that the database `kpicursor` exists
- Verify username/password are correct
- Make sure PHP has MySQL extension enabled

### Permission Issues
- Ensure the MySQL user has CREATE, DROP, and ALTER privileges
- Check that the database user can create tables

### Migration Issues
- Run `php artisan migrate:status` to check migration status
- Use `php artisan migrate:rollback` if needed
- Check Laravel logs in `storage/logs/` for detailed error messages

## Verification

After setup, you can verify the installation by:

1. Accessing `http://localhost:8000`
2. Logging in with test@example.com / password
3. Creating a new KPI
4. Adding data points
5. Viewing the dashboard charts

## Production Considerations

For production deployment:

1. Change the default database password
2. Set `APP_ENV=production`
3. Set `APP_DEBUG=false`
4. Use a strong `APP_KEY`
5. Configure proper MySQL user permissions
6. Set up database backups
7. Use environment-specific configuration

## Support

If you encounter issues:

1. Check the Laravel logs in `storage/logs/laravel.log`
2. Verify MySQL connection with `php artisan tinker` and test DB connection
3. Ensure all required PHP extensions are installed
4. Check that the database exists and is accessible
