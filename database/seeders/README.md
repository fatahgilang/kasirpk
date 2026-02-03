# Database Seeders

Kumpulan seeders untuk mengisi database dengan data dummy yang realistis untuk sistem POS Toko Pakan Ternak.

## Daftar Seeders

### 1. UserSeeder
- **Deskripsi**: Membuat user admin dan kasir
- **Data**: 4 user (Admin, Kasir 1, Kasir 2, Manager)
- **Login**: email/password untuk semua user adalah `password`

### 2. CategorySeeder
- **Deskripsi**: Kategori produk pakan ternak
- **Data**: 10 kategori (Pakan Ayam, Sapi, Kambing, Bebek, Ikan, Obat-obatan, Vitamin, Vaksin, Peralatan, Desinfektan)

### 3. UnitSeeder
- **Deskripsi**: Unit satuan untuk produk
- **Data**: 13 unit (kg, gram, ton, karung, sak, liter, botol, tablet, kapsul, sachet, strip, pieces)

### 4. SupplierSeeder
- **Deskripsi**: Data supplier/pemasok
- **Data**: 6 supplier (CP, Japfa, Cargill, Medion, Sanbe, CV Mitra)

### 5. CustomerSeeder
- **Deskripsi**: Data pelanggan
- **Data**: 10 pelanggan dengan berbagai jenis ternak dan tipe customer

### 6. ProductSeeder
- **Deskripsi**: Produk pakan ternak dan obat-obatan
- **Data**: 20+ produk lengkap dengan stok, harga, dan informasi detail

### 7. ProductUnitSeeder
- **Deskripsi**: Unit alternatif untuk produk (karung, sak, strip, dll)
- **Data**: Unit konversi dengan harga berbeda

### 8. PurchaseSeeder
- **Deskripsi**: Data pembelian dari supplier
- **Data**: 15 pembelian dummy untuk 30 hari terakhir

### 9. TransactionSeeder
- **Deskripsi**: Data transaksi penjualan
- **Data**: 20 transaksi dummy untuk 7 hari terakhir

### 10. PaymentSeeder
- **Deskripsi**: Data pembayaran
- **Data**: Pembayaran untuk transaksi dan pembelian

### 11. CashierShiftSeeder
- **Deskripsi**: Data shift kasir
- **Data**: Shift kasir untuk 7 hari terakhir + 1 shift aktif

## Cara Menjalankan

### Menjalankan Semua Seeders
```bash
php artisan db:seed
```

### Menjalankan Seeder Tertentu
```bash
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
```

### Reset Database dan Seed Ulang
```bash
php artisan migrate:fresh --seed
```

## Urutan Eksekusi

Seeders akan dijalankan dalam urutan berikut (sesuai dependencies):

1. **UserSeeder** - User sistem
2. **CategorySeeder** - Kategori produk
3. **UnitSeeder** - Unit satuan
4. **SupplierSeeder** - Data supplier
5. **CustomerSeeder** - Data pelanggan
6. **ProductSeeder** - Data produk
7. **ProductUnitSeeder** - Unit alternatif produk
8. **PurchaseSeeder** - Data pembelian
9. **TransactionSeeder** - Data penjualan
10. **PaymentSeeder** - Data pembayaran
11. **CashierShiftSeeder** - Data shift kasir

## Data Login

Setelah menjalankan seeder, Anda dapat login dengan:

- **Admin**: admin@pos.com / password
- **Kasir 1**: kasir1@pos.com / password
- **Kasir 2**: kasir2@pos.com / password
- **Manager**: manager@pos.com / password

## Catatan Penting

1. **Backup Database**: Selalu backup database sebelum menjalankan seeder
2. **Environment**: Pastikan menjalankan di environment yang tepat
3. **Dependencies**: Beberapa seeder memiliki dependencies, jalankan sesuai urutan
4. **Data Realistis**: Semua data dibuat realistis untuk bisnis pakan ternak
5. **Stok Produk**: Produk memiliki stok yang cukup untuk testing POS

## Troubleshooting

### Error Foreign Key Constraint
```bash
# Disable foreign key checks sementara
php artisan db:seed --class=DatabaseSeeder
```

### Error Duplicate Entry
```bash
# Reset database terlebih dahulu
php artisan migrate:fresh
php artisan db:seed
```

### Memory Limit
```bash
# Increase memory limit
php -d memory_limit=512M artisan db:seed
```