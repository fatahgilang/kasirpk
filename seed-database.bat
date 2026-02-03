@echo off
REM POS Toko Pakan Ternak - Database Seeder Script
REM This script will seed your database with comprehensive test data

echo 🚀 POS Toko Pakan Ternak - Database Seeder
echo ==========================================
echo.

REM Check if Laravel is installed
if not exist "artisan" (
    echo ❌ Error: artisan file not found. Make sure you're in the Laravel project root.
    pause
    exit /b 1
)

REM Check database connection
echo 🔍 Checking database connection...
php artisan migrate:status >nul 2>&1
if errorlevel 1 (
    echo ❌ Error: Cannot connect to database. Please check your .env configuration.
    pause
    exit /b 1
)

echo ✅ Database connection successful
echo.

REM Ask user for confirmation
echo ⚠️  WARNING: This will add test data to your database.
echo    Make sure you're running this on a development/testing environment.
echo.
set /p confirm="Do you want to continue? (y/N): "

if /i not "%confirm%"=="y" (
    echo ❌ Seeding cancelled.
    pause
    exit /b 1
)

echo.
echo 🌱 Starting database seeding...
echo.

REM Run the comprehensive seeder
php artisan db:seed

REM Check if seeding was successful
if errorlevel 1 (
    echo.
    echo ❌ Database seeding failed. Please check the error messages above.
    pause
    exit /b 1
) else (
    echo.
    echo 🎉 Database seeding completed successfully!
    echo.
    echo 🔗 You can now access your POS system:
    echo    - URL: http://localhost:8000/admin
    echo    - Login: admin@pos.com / password
    echo.
    echo 📱 Available user accounts:
    echo    - Admin: admin@pos.com
    echo    - Kasir 1: kasir1@pos.com
    echo    - Kasir 2: kasir2@pos.com
    echo    - Manager: manager@pos.com
    echo    - Password for all: password
    echo.
    echo 📊 Data seeded:
    echo    - 5 Users (including admin)
    echo    - 10 Product categories
    echo    - 13 Units of measurement
    echo    - 6 Suppliers
    echo    - 5 Customers
    echo    - 8 Products with stock
    echo    - 15 Sample transactions
    echo.
    echo 🎯 Your POS system is ready for testing!
)

pause