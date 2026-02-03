#!/bin/bash

# POS Toko Pakan Ternak - Database Seeder Script
# This script will seed your database with comprehensive test data

echo "🚀 POS Toko Pakan Ternak - Database Seeder"
echo "=========================================="
echo ""

# Check if Laravel is installed
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Make sure you're in the Laravel project root."
    exit 1
fi

# Check database connection
echo "🔍 Checking database connection..."
php artisan migrate:status > /dev/null 2>&1
if [ $? -ne 0 ]; then
    echo "❌ Error: Cannot connect to database. Please check your .env configuration."
    exit 1
fi

echo "✅ Database connection successful"
echo ""

# Ask user for confirmation
echo "⚠️  WARNING: This will add test data to your database."
echo "   Make sure you're running this on a development/testing environment."
echo ""
read -p "Do you want to continue? (y/N): " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Seeding cancelled."
    exit 1
fi

echo ""
echo "🌱 Starting database seeding..."
echo ""

# Run the comprehensive seeder
php artisan db:seed

# Check if seeding was successful
if [ $? -eq 0 ]; then
    echo ""
    echo "🎉 Database seeding completed successfully!"
    echo ""
    echo "🔗 You can now access your POS system:"
    echo "   - URL: http://localhost:8000/admin"
    echo "   - Login: admin@pos.com / password"
    echo ""
    echo "📱 Available user accounts:"
    echo "   - Admin: admin@pos.com"
    echo "   - Kasir 1: kasir1@pos.com"
    echo "   - Kasir 2: kasir2@pos.com"
    echo "   - Manager: manager@pos.com"
    echo "   - Password for all: password"
    echo ""
    echo "📊 Data seeded:"
    echo "   - 5 Users (including admin)"
    echo "   - 10 Product categories"
    echo "   - 13 Units of measurement"
    echo "   - 6 Suppliers"
    echo "   - 5 Customers"
    echo "   - 8 Products with stock"
    echo "   - 15 Sample transactions"
    echo ""
    echo "🎯 Your POS system is ready for testing!"
else
    echo ""
    echo "❌ Database seeding failed. Please check the error messages above."
    exit 1
fi