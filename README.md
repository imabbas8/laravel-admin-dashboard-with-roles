<div align="center">

# 🚀 Laravel Admin Dashboard

### A powerful, production-ready Admin Dashboard with Dynamic Modules System & Role-Permission Management

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

[Features](#-features) • [Screenshots](#-screenshots) • [Installation](#-installation) • [Modules](#-modules-system) • [Roles](#-role--permission-system) • [API](#-api-documentation)

</div>

---

## 📌 Overview

A **full-featured Laravel Admin Dashboard** designed for scalability and maintainability. Built with a **dynamic module system** that allows you to plug and unplug features independently, combined with a **granular role & permission system** for complete access control.

> ✅ Perfect for SaaS applications, enterprise systems, and any project that needs a solid admin foundation.

---

## ✨ Features

### 🎛️ Dashboard
- 📊 Real-time analytics & statistics cards
- 📈 Interactive charts (revenue, users, traffic)
- 🔔 Notification center
- 🌙 Dark / Light mode toggle
- 📱 Fully responsive (mobile-first design)
- ⚡ Fast loading with optimized queries

### 🧩 Dynamic Modules System
- Plug & play module architecture
- Enable / disable modules from admin panel
- Each module is fully independent
- Auto-registers routes, views, migrations
- Module-level permissions support

### 🔐 Role & Permission System
- Multi-role support per user
- Granular permission control (CRUD level)
- Permission groups per module
- Role hierarchy support
- Middleware-based route protection
- UI-based permission assignment

### 👥 User Management
- Create, edit, delete users
- Assign multiple roles
- User activity logs
- Profile management
- Avatar upload
- Account status (active/inactive/banned)

### 📦 Built-in Modules
| Module | Description |
|--------|-------------|
| 👤 Users | Full user management |
| 🔐 Roles & Permissions | Access control |
| 📊 Analytics | Charts & reports |
| ⚙️ Settings | System configuration |
| 📝 Audit Logs | Activity tracking |
| 📧 Email Templates | Transactional emails |
| 🗂️ Media Manager | File & image management |
| 🔔 Notifications | In-app & email alerts |

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Framework** | Laravel 10.x |
| **PHP Version** | PHP 8.1+ |
| **Database** | MySQL 8.0 / PostgreSQL |
| **Frontend** | Blade + Alpine.js + Tailwind CSS |
| **Auth** | Laravel Sanctum / Breeze |
| **Permissions** | Spatie Laravel Permission |
| **Charts** | Chart.js / ApexCharts |
| **File Storage** | Laravel Storage + S3 support |
| **Queue** | Laravel Queue (Redis/Database) |
| **Cache** | Redis / File |

---

## 📋 Requirements

Before you begin, make sure you have the following installed:

- **PHP** >= 8.1
- **Composer** >= 2.0
- **MySQL** >= 8.0 or **PostgreSQL** >= 13
- **Node.js** >= 18.x & **NPM** >= 9.x
- **Redis** (optional, for queues & cache)

---

## 🚀 Installation

### Step 1 — Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/laravel-dashboard.git
cd laravel-dashboard
```

### Step 2 — Install PHP Dependencies

```bash
composer install
```

### Step 3 — Install Node Dependencies

```bash
npm install
```

### Step 4 — Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### Step 5 — Configure `.env` File

```env
APP_NAME="Laravel Dashboard"
APP_ENV=local
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_dashboard
DB_USERNAME=root
DB_PASSWORD=your_password

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS=noreply@yourdomain.com

# Cache & Queue
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Step 6 — Database Setup

```bash
# Create tables
php artisan migrate

# Seed with default data (admin user, roles, permissions)
php artisan db:seed

# Or run both together
php artisan migrate --seed
```

### Step 7 — Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### Step 8 — Start the Server

```bash
php artisan serve
```

🎉 **Visit:** `http://localhost:8000`

---

## 🔑 Default Credentials

After seeding the database, use these credentials to login:

| Role | Email | Password |
|------|-------|----------|
| **Super Admin** | admin@dashboard.com | password |
| **Admin** | manager@dashboard.com | password |
| **User** | user@dashboard.com | password |

> ⚠️ **Important:** Change default passwords immediately in production!

---

## 🧩 Modules System

### How Modules Work

Each module lives in its own directory under `app/Modules/`:

```
app/
└── Modules/
    ├── Users/
    │   ├── Controllers/
    │   ├── Models/
    │   ├── Views/
    │   ├── Routes/
    │   ├── Migrations/
    │   └── module.json
    ├── Analytics/
    ├── Settings/
    ├── AuditLogs/
    └── MediaManager/
```

### Enable / Disable a Module

```bash
# Enable a module
php artisan module:enable Analytics

# Disable a module
php artisan module:disable Analytics

# List all modules with status
php artisan module:list
```

### Create a New Module

```bash
php artisan module:make Blog
```

This auto-generates:
- ✅ Controller, Model, Migration
- ✅ Routes (web + api)
- ✅ Views (index, create, edit, show)
- ✅ Permissions registration
- ✅ Sidebar menu entry

---

## 🔐 Role & Permission System

### Default Roles

| Role | Description |
|------|-------------|
| `super-admin` | Full access to everything |
| `admin` | Access to all modules except system settings |
| `manager` | Access to assigned modules only |
| `user` | Basic access, limited permissions |

### Default Permissions (per module)

```
module.view      — View list / index
module.create    — Create new records
module.edit      — Edit existing records
module.delete    — Delete records
module.export    — Export data
module.import    — Import data
```

### Assigning Roles in Code

```php
// Assign role to user
$user->assignRole('admin');

// Assign multiple roles
$user->assignRole(['admin', 'manager']);

// Check role
$user->hasRole('admin');

// Check permission
$user->can('users.delete');
```

### Protecting Routes with Middleware

```php
// Role-based
Route::middleware(['role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

// Permission-based
Route::middleware(['permission:users.delete'])->group(function () {
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});
```

### Blade Directives

```blade
{{-- Check role --}}
@role('admin')
    <button>Admin Only Button</button>
@endrole

{{-- Check permission --}}
@can('users.delete')
    <button class="btn-danger">Delete User</button>
@endcan
```

---

## 📁 Project Structure

```
laravel-dashboard/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Modules/              ← Dynamic modules live here
│       ├── Users/
│       ├── Analytics/
│       ├── Settings/
│       └── AuditLogs/
├── config/
│   └── modules.php           ← Module configuration
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── RoleSeeder.php
│       ├── PermissionSeeder.php
│       └── AdminUserSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   └── sidebar.blade.php
│       └── dashboard/
├── routes/
│   ├── web.php
│   └── api.php
└── tests/
    ├── Feature/
    └── Unit/
```

---

## 🔧 Configuration

### Modules Config (`config/modules.php`)

```php
return [
    'modules' => [
        'Users'        => true,   // enabled
        'Analytics'    => true,   // enabled
        'AuditLogs'    => true,   // enabled
        'MediaManager' => false,  // disabled
    ],

    'module_path' => app_path('Modules'),
    'auto_discover' => true,
];
```

---

## 🧪 Running Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

---

## 📦 Deployment (Production)

```bash
# Optimize for production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Build frontend assets
npm run build

# Run migrations
php artisan migrate --force

# Start queue worker
php artisan queue:work --daemon
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/amazing-feature`
3. Commit your changes: `git commit -m 'Add some amazing feature'`
4. Push to the branch: `git push origin feature/amazing-feature`
5. Open a Pull Request

---

## 📄 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**Your Name**
- GitHub: [@your-username](https://github.com/your-username)
- LinkedIn: [your-linkedin](https://linkedin.com/in/your-profile)
- Email: your@email.com

---

<div align="center">

**⭐ If this project helped you, please give it a star!**

Made with ❤️ using Laravel

</div>
