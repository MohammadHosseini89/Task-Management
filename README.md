# Task Management System

A self-designed task management platform built with Laravel, Livewire, and Blade, focused on improving productivity, team collaboration, and workflow management.

## Features

* ✅ Task creation, assignment, and tracking
* ✅ User and role management
* ✅ Batch processing for bulk operations
* ✅ Real-time interactions with Livewire
* ✅ Responsive UI using Laravel Blade
* ✅ Authentication and authorization
* ✅ Dashboard and reporting capabilities
* ✅ Scalable and maintainable architecture

## Technology Stack

* Laravel
* Livewire
* Laravel Blade
* MySQL
* Bootstrap / Tailwind CSS
* Eloquent ORM

## Project Highlights

* Designed and developed from scratch
* Clean architecture and modular codebase
* Optimized database queries and backend performance
* Enterprise-ready user management and permission handling
* Efficient batch processing workflows for large datasets

## Installation

```bash
git clone https://github.com/yourusername/task-management-system.git

cd task-management-system

composer install

npm install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan serve

npm run dev
```

## Scheduler Testing

To test scheduled tasks:

```bash
php artisan schedule:test
```

## Default User

After installation, you can log in using the following credentials:

```text
Email: superadmin@urcompany.com
Password: 2wsx@WSX
```

## Configuration Notes

If you encounter issues with Livewire assets, make sure the following values are configured correctly in your application configuration:

```php
// config/livewire.php

'app_url' => env('APP_URL'),

'asset_url' => env('ASSET_URL'),
```

Also ensure your `.env` file contains the correct URLs:

```env
APP_URL=http://localhost:8000
ASSET_URL=http://localhost:8000
```

## Screenshots

### Dashboard

Add a screenshot here:

```text
/screenshots/dashboard.png
```

### Task Board

Add a screenshot here:

```text
/screenshots/task-board.png
```

### User Management

Add a screenshot here:

```text
/screenshots/user-management.png
```

### Batch Processing Module

Add a screenshot here:

```text
/screenshots/batch-processing.png
```

## Future Enhancements

* Notifications and reminders
* Activity logs and audit trails
* REST API integration
* Mobile-friendly improvements
* Advanced reporting and analytics

## Author

Developed by a Senior Laravel Backend Developer with 10+ years of experience in enterprise software development.

---

⭐ If you find this project useful, consider giving it a star.
