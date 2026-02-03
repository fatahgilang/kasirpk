# 🌱 Database Seeder Guide - POS Toko Pakan Ternak

Panduan lengkap untuk mengisi database dengan data dummy yang realistis untuk sistem POS Toko Pakan Ternak.

## 🚀 Quick Start

### Metode 1: Menggunakan Script Otomatis (Recommended)

**Linux/Mac:**
```bash
./seed-database.sh
```

**Windows:**
```cmd
seed-database.bat
```

### Metode 2: Manual Laravel Command

```bash
# Seed semua data dengan progress tracking
php artisan db:seed --class=RunSeeders

# Atau seed menggunakan DatabaseSeeder standar
php artisan db:seed
```

### Metode 3: Reset Database + Seed

```bash
# Reset database dan seed ulang (HATI-HATI: Menghapus semua data!)
php artisan migrate:fresh --seed
```

## 📊 Data yang Akan Dibuat

### 👤 Users (4 user)
- **Admin**: admin@pos.com / password
- **Kasir 1**: kasir1@pos.com / password  
- **Kasir 2**: kasir2@pos.com / password
- **Manager**: manager@pos.com / password

### 📂 Categories (10 kategori)
- Pakan Ayam, Sapi, Kambing, Bebek, Ikan
- Obat-obatan, Vitamin & Suplemen, Vaksin
- Peralatan Kandang, Desinfektan

### 📏 Units (13 unit)
- Berat: kg, gram, ton
- Kemasan: karung, sak, botol, sachet, strip
- Volume: liter, mililiter
- Satuan: pieces, tablet, kapsul

### 🏭 Suppliers (6 supplier)
- PT Charoen Pokphand Indonesia
- PT Japfa Comfeed Indonesia  
- PT Cargill Indonesia
- PT Medion Ardhika Bhakti
- PT Sanbe Farma
- CV Mitra Pakan Ternak

### 👥 Customers (10 pelanggan)
- Mix retail dan wholesale customers
- Berbagai jenis ternak (ayam, sapi, kambing, dll)
- Dengan credit limit dan payment terms

### 📦 Products (20+ produk)
- Pakan lengkap untuk berbagai ternak
- Obat-obatan dan vitamin
- Peralatan kandang dan desinfektan
- Dengan stok, harga, dan informasi detail

### 🔄 Product Units
- Unit alternatif untuk setiap produk
- Konversi otomatis (kg → karung, tablet → strip)
- Harga berbeda per unit

### 🛒 Purchases (15 pembelian)
- Data pembelian 30 hari terakhir
- Berbagai status pembayaran
- Realistic purchase amounts

### 💰 Transactions (20 transaksi)
- Data penjualan 7 hari terakhir
- Mix cash dan credit transactions
- Multiple items per transaction

### 💳 Payments
- Pembayaran untuk transaksi kredit
- Pembayaran ke supplier
- Berbagai metode pembayaran

### ⏰ Cashier Shifts
- Shift kasir 7 hari terakhir
- 1 shift aktif untuk testing
- Realistic sales data

## 🔧 Troubleshooting

### Error: Foreign Key Constraint
```bash
# Disable foreign key checks
php artisan db:seed --class=RunSeeders
```

### Error: Duplicate Entry
```bash
# Reset database first
php artisan migrate:fresh
php artisan db:seed
```

### Error: Memory Limit
```bash
# Increase memory limit
php -d memory_limit=512M artisan db:seed
```

### Error: Database Connection
1. Check `.env` file configuration
2. Ensure database exists
3. Test connection: `php artisan migrate:status`

## 📋 Pre-Requirements

1. ✅ Laravel project setup
2. ✅ Database configured in `.env`
3. ✅ All migrations run (`php artisan migrate`)
4. ✅ Filament admin panel installed

## 🎯 After Seeding

### 1. Access Admin Panel
- URL: `http://localhost:8000/admin`
- Login: `admin@pos.com` / `password`

### 2. Test POS System
- Go to "Kasir (POS)" menu
- Add products to cart
- Process transactions
- Check inventory updates

### 3. Explore Features
- **Dashboard**: View sales statistics
- **Products**: Manage inventory
- **Customers**: Customer management
- **Transactions**: Sales history
- **Reports**: Various business reports

## 🔒 Security Notes

⚠️ **IMPORTANT**: 
- Only run seeders in development/testing environment
- Never run on production database
- Default passwords are weak - change in production
- Backup database before seeding

## 📞 Support

Jika mengalami masalah:

1. Check error messages carefully
2. Ensure all migrations are run
3. Verify database connection
4. Check Laravel logs: `storage/logs/laravel.log`

## 🎉 Success Indicators

After successful seeding, you should see:
- ✅ All tables populated with data
- ✅ POS system functional
- ✅ Products with stock available
- ✅ Customers ready for transactions
- ✅ Dashboard showing statistics

---

**Happy Testing! 🚀**

Your POS Toko Pakan Ternak system is now ready with comprehensive test data.