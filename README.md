# KPI Management System

A comprehensive Key Performance Indicator (KPI) management system built with Laravel, featuring user authentication, data visualization, and advanced analytics.

## Features

### 🔐 User Authentication
- User registration and login
- Secure password hashing
- Session management
- User-specific data isolation

### 📊 KPI Management
- Create, read, update, and delete KPIs
- Categorize KPIs for better organization
- Set target values and track progress
- Multiple measurement types (higher is better, lower is better, target value)
- Flexible frequency settings (daily, weekly, monthly, quarterly, yearly)

### 📈 Data Visualization
- Interactive dashboard with Chart.js
- Performance trend charts
- Category distribution pie charts
- Progress tracking with visual indicators
- Real-time data updates

### 🎨 Modern UI/UX
- Responsive Bootstrap 5 design
- Beautiful gradient themes
- Intuitive navigation
- Mobile-friendly interface
- Interactive charts and graphs

### 📋 Category Management
- Create and manage KPI categories
- Color-coded categories
- Category-based filtering
- Statistics and analytics per category

### 📊 Advanced Analytics
- Progress percentage calculations
- Performance trend analysis
- Data history tracking
- Export capabilities
- Comprehensive reporting

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and NPM (for frontend assets)
- SQLite, MySQL, or PostgreSQL

### Setup Instructions

#### Option 1: Quick Setup (Windows)
1. **Run the setup script**
   ```bash
   setup-mysql.bat
   ```
   This will automatically configure MySQL and set up the database.

#### Option 2: Manual Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd kpi-management-system
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Create MySQL database**
   ```sql
   CREATE DATABASE kpicursor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Environment setup**
   - Create `.env` file with MySQL configuration:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=kpicursor
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   - Generate application key:
   ```bash
   php artisan key:generate
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   - Open your browser and go to `http://localhost:8000`
   - Use the test account:
     - Email: `test@example.com`
     - Password: `password`

## Project Structure

```
kpi-management-system/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── KpiController.php
│   │   └── KpiCategoryController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Kpi.php
│   │   ├── KpiCategory.php
│   │   └── KpiData.php
│   └── Policies/
│       └── KpiPolicy.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── KpiCategorySeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── dashboard/
│       ├── kpis/
│       └── categories/
└── routes/
    └── web.php
```

## Database Schema

### Users Table
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email address
- `password` - Hashed password
- `created_at`, `updated_at` - Timestamps

### KPI Categories Table
- `id` - Primary key
- `name` - Category name
- `description` - Category description
- `color` - Hex color code for UI
- `is_active` - Active status
- `created_at`, `updated_at` - Timestamps

### KPIs Table
- `id` - Primary key
- `name` - KPI name
- `description` - KPI description
- `kpi_category_id` - Foreign key to categories
- `user_id` - Foreign key to users
- `unit` - Unit of measurement
- `measurement_type` - Type of measurement
- `target_value` - Target value
- `current_value` - Current value
- `start_date` - Start date
- `end_date` - End date (optional)
- `frequency` - Update frequency
- `is_active` - Active status
- `created_at`, `updated_at` - Timestamps

### KPI Data Table
- `id` - Primary key
- `kpi_id` - Foreign key to KPIs
- `user_id` - Foreign key to users
- `value` - Data value
- `recorded_date` - Date of recording
- `notes` - Optional notes
- `created_at`, `updated_at` - Timestamps

## Key Features Explained

### Dashboard
- **Statistics Cards**: Display total KPIs, active KPIs, completed KPIs, and completion rate
- **Performance Chart**: Line chart showing KPI performance over the last 30 days
- **Category Distribution**: Pie chart showing KPI distribution across categories
- **Recent Data**: Table of recent KPI data entries
- **Quick Actions**: Easy access to create KPIs and categories

### KPI Management
- **Create KPIs**: Set up new KPIs with detailed configuration
- **Track Progress**: Visual progress bars and percentage calculations
- **Add Data**: Record new data points with timestamps and notes
- **Performance Trends**: Line charts showing KPI performance over time
- **Edit/Delete**: Full CRUD operations with proper authorization

### Category Management
- **Color-coded Categories**: Visual organization with custom colors
- **Category Statistics**: Track KPIs per category
- **Flexible Organization**: Create unlimited categories
- **Category-based Filtering**: Filter KPIs by category

## API Endpoints

### Authentication
- `GET /login` - Show login form
- `POST /login` - Process login
- `GET /register` - Show registration form
- `POST /register` - Process registration
- `POST /logout` - Logout user

### Dashboard
- `GET /dashboard` - Main dashboard

### KPIs
- `GET /kpis` - List all KPIs
- `GET /kpis/create` - Show create form
- `POST /kpis` - Store new KPI
- `GET /kpis/{kpi}` - Show KPI details
- `GET /kpis/{kpi}/edit` - Show edit form
- `PUT /kpis/{kpi}` - Update KPI
- `DELETE /kpis/{kpi}` - Delete KPI
- `POST /kpis/{kpi}/data` - Add data point

### Categories
- `GET /categories` - List all categories
- `GET /categories/create` - Show create form
- `POST /categories` - Store new category
- `GET /categories/{category}` - Show category details
- `GET /categories/{category}/edit` - Show edit form
- `PUT /categories/{category}` - Update category
- `DELETE /categories/{category}` - Delete category

## Security Features

- **User Authentication**: Secure login/logout system
- **Authorization**: Users can only access their own KPIs
- **CSRF Protection**: All forms protected against CSRF attacks
- **Input Validation**: Comprehensive validation on all inputs
- **SQL Injection Prevention**: Eloquent ORM with parameterized queries

## Technologies Used

### Backend
- **Laravel 11** - PHP framework
- **Eloquent ORM** - Database abstraction
- **Laravel Policies** - Authorization
- **Laravel Migrations** - Database versioning
- **Laravel Seeders** - Database seeding

### Frontend
- **Bootstrap 5** - CSS framework
- **Chart.js** - Data visualization
- **Font Awesome** - Icons
- **Responsive Design** - Mobile-friendly

### Database
- **SQLite** (default) - Lightweight database
- **MySQL/PostgreSQL** - Production databases supported

## Customization

### Adding New KPI Types
1. Update the `measurement_type` enum in the migration
2. Add new options to the create/edit forms
3. Update validation rules in controllers

### Styling
- Modify CSS in `resources/views/layouts/app.blade.php`
- Update Bootstrap classes for different themes
- Customize Chart.js configurations

### Database
- Add new fields to existing tables via migrations
- Create new relationships in models
- Update seeders for new data

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions:
- Create an issue in the repository
- Check the documentation
- Review the code comments

## Future Enhancements

- [ ] Data export to Excel/CSV
- [ ] Email notifications for KPI updates
- [ ] Advanced reporting features
- [ ] API endpoints for mobile apps
- [ ] Team collaboration features
- [ ] Advanced analytics and insights
- [ ] Integration with external data sources
- [ ] Automated KPI calculations
- [ ] Goal setting and tracking
- [ ] Performance benchmarking

---

**Built with ❤️ using Laravel and modern web technologies**