<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ComprehensiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting comprehensive database seeding...');
        
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear all tables
        $this->command->info('🧹 Clearing existing data...');
        TransactionItem::truncate();
        Transaction::truncate();
        Product::truncate();
        Customer::truncate();
        Supplier::truncate();
        Unit::truncate();
        Category::truncate();
        User::where('id', '>', 1)->delete(); // Keep first user if exists
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Seed Users
        $this->command->info('👤 Seeding users...');
        $this->seedUsers();
        
        // Seed Categories
        $this->command->info('📂 Seeding categories...');
        $this->seedCategories();
        
        // Seed Units
        $this->command->info('📏 Seeding units...');
        $this->seedUnits();
        
        // Seed Suppliers
        $this->command->info('🏭 Seeding suppliers...');
        $this->seedSuppliers();
        
        // Seed Customers
        $this->command->info('👥 Seeding customers...');
        $this->seedCustomers();
        
        // Seed Products
        $this->command->info('📦 Seeding products...');
        $this->seedProducts();
        
        // Seed Transactions
        $this->command->info('💰 Seeding transactions...');
        $this->seedTransactions();
        
        $this->command->info('');
        $this->command->info('🎉 Database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info('- Users: ' . User::count());
        $this->command->info('- Categories: ' . Category::count());
        $this->command->info('- Units: ' . Unit::count());
        $this->command->info('- Suppliers: ' . Supplier::count());
        $this->command->info('- Customers: ' . Customer::count());
        $this->command->info('- Products: ' . Product::count());
        $this->command->info('- Transactions: ' . Transaction::count());
        $this->command->info('- Transaction Items: ' . TransactionItem::count());
        $this->command->info('');
        $this->command->info('🔑 Login credentials:');
        $this->command->info('- Admin: admin@pos.com / password');
        $this->command->info('- Kasir 1: kasir1@pos.com / password');
        $this->command->info('- Kasir 2: kasir2@pos.com / password');
        $this->command->info('- Manager: manager@pos.com / password');
    }
    
    private function seedUsers()
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@pos.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Kasir 1',
                'email' => 'kasir1@pos.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Kasir 2',
                'email' => 'kasir2@pos.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@pos.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
    
    private function seedCategories()
    {
        $categories = [
            [
                'name' => 'Pakan Ayam',
                'slug' => 'pakan-ayam',
                'description' => 'Pakan untuk ayam broiler, layer, dan kampung',
                'icon' => 'heroicon-o-home',
                'color' => '#f59e0b',
                'is_active' => true,
            ],
            [
                'name' => 'Pakan Sapi',
                'slug' => 'pakan-sapi',
                'description' => 'Pakan untuk sapi potong dan perah',
                'icon' => 'heroicon-o-home',
                'color' => '#8b5cf6',
                'is_active' => true,
            ],
            [
                'name' => 'Pakan Kambing',
                'slug' => 'pakan-kambing',
                'description' => 'Pakan untuk kambing dan domba',
                'icon' => 'heroicon-o-home',
                'color' => '#10b981',
                'is_active' => true,
            ],
            [
                'name' => 'Pakan Bebek',
                'slug' => 'pakan-bebek',
                'description' => 'Pakan untuk bebek petelur dan pedaging',
                'icon' => 'heroicon-o-home',
                'color' => '#06b6d4',
                'is_active' => true,
            ],
            [
                'name' => 'Pakan Ikan',
                'slug' => 'pakan-ikan',
                'description' => 'Pakan untuk ikan lele, nila, dan gurame',
                'icon' => 'heroicon-o-home',
                'color' => '#3b82f6',
                'is_active' => true,
            ],
            [
                'name' => 'Obat-obatan',
                'slug' => 'obat-obatan',
                'description' => 'Obat-obatan dan antibiotik untuk ternak',
                'icon' => 'heroicon-o-beaker',
                'color' => '#ef4444',
                'is_active' => true,
            ],
            [
                'name' => 'Vitamin & Suplemen',
                'slug' => 'vitamin-suplemen',
                'description' => 'Vitamin dan suplemen untuk ternak',
                'icon' => 'heroicon-o-heart',
                'color' => '#06b6d4',
                'is_active' => true,
            ],
            [
                'name' => 'Vaksin',
                'slug' => 'vaksin',
                'description' => 'Vaksin untuk pencegahan penyakit ternak',
                'icon' => 'heroicon-o-shield-check',
                'color' => '#84cc16',
                'is_active' => true,
            ],
            [
                'name' => 'Peralatan Kandang',
                'slug' => 'peralatan-kandang',
                'description' => 'Peralatan dan aksesoris kandang',
                'icon' => 'heroicon-o-wrench-screwdriver',
                'color' => '#6b7280',
                'is_active' => true,
            ],
            [
                'name' => 'Desinfektan',
                'slug' => 'desinfektan',
                'description' => 'Desinfektan dan pembersih kandang',
                'icon' => 'heroicon-o-beaker',
                'color' => '#14b8a6',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
    
    private function seedUnits()
    {
        $units = [
            // Unit Berat
            [
                'name' => 'Kilogram',
                'symbol' => 'kg',
                'description' => 'Unit berat dasar',
                'is_base_unit' => true,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Gram',
                'symbol' => 'g',
                'description' => 'Unit berat kecil',
                'is_base_unit' => false,
                'conversion_factor' => 0.001,
            ],
            [
                'name' => 'Ton',
                'symbol' => 'ton',
                'description' => 'Unit berat besar',
                'is_base_unit' => false,
                'conversion_factor' => 1000,
            ],
            [
                'name' => 'Karung',
                'symbol' => 'krg',
                'description' => 'Kemasan karung (biasanya 50kg)',
                'is_base_unit' => false,
                'conversion_factor' => 50,
            ],
            [
                'name' => 'Sak',
                'symbol' => 'sak',
                'description' => 'Kemasan sak',
                'is_base_unit' => false,
                'conversion_factor' => 25,
            ],
            [
                'name' => 'Liter',
                'symbol' => 'L',
                'description' => 'Unit volume',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Mililiter',
                'symbol' => 'ml',
                'description' => 'Unit volume kecil',
                'is_base_unit' => false,
                'conversion_factor' => 0.001,
            ],
            [
                'name' => 'Botol',
                'symbol' => 'btl',
                'description' => 'Kemasan botol',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Tablet',
                'symbol' => 'tab',
                'description' => 'Unit tablet/pil',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Kapsul',
                'symbol' => 'kps',
                'description' => 'Unit kapsul',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Sachet',
                'symbol' => 'sct',
                'description' => 'Kemasan sachet',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
            [
                'name' => 'Strip',
                'symbol' => 'strip',
                'description' => 'Kemasan strip (biasanya 10 tablet)',
                'is_base_unit' => false,
                'conversion_factor' => 10,
            ],
            [
                'name' => 'Pieces',
                'symbol' => 'pcs',
                'description' => 'Unit satuan',
                'is_base_unit' => false,
                'conversion_factor' => 1,
            ],
        ];

        foreach ($units as $unitData) {
            Unit::create($unitData);
        }
    }
    
    private function seedSuppliers()
    {
        $suppliers = [
            [
                'code' => 'SUP-001',
                'name' => 'PT Charoen Pokphand Indonesia',
                'company_name' => 'PT Charoen Pokphand Indonesia',
                'contact_person' => 'Budi Hartono',
                'email' => 'sales@cpi.co.id',
                'phone' => '021-12345678',
                'address' => 'Jl. Ancol Barat No. 1, Jakarta Utara',
                'payment_term_days' => 30,
                'current_payable' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'SUP-002',
                'name' => 'PT Japfa Comfeed Indonesia',
                'company_name' => 'PT Japfa Comfeed Indonesia',
                'contact_person' => 'Siti Rahayu',
                'email' => 'procurement@japfa.com',
                'phone' => '021-87654321',
                'address' => 'Jl. Letjen S. Parman Kav. 35, Jakarta Barat',
                'payment_term_days' => 45,
                'current_payable' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'SUP-003',
                'name' => 'PT Cargill Indonesia',
                'company_name' => 'PT Cargill Indonesia',
                'contact_person' => 'Ahmad Wijaya',
                'email' => 'sales@cargill.co.id',
                'phone' => '021-11223344',
                'address' => 'Jl. HR Rasuna Said Kav. C-22, Jakarta Selatan',
                'payment_term_days' => 30,
                'current_payable' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'SUP-004',
                'name' => 'PT Medion Ardhika Bhakti',
                'company_name' => 'PT Medion Ardhika Bhakti',
                'contact_person' => 'Dr. Dewi Lestari',
                'email' => 'sales@medion.co.id',
                'phone' => '0251-8123456',
                'address' => 'Jl. Raya Bogor KM 27, Cibinong, Bogor',
                'payment_term_days' => 21,
                'current_payable' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'SUP-005',
                'name' => 'PT Sanbe Farma',
                'company_name' => 'PT Sanbe Farma',
                'contact_person' => 'Rudi Hermawan',
                'email' => 'marketing@sanbe.co.id',
                'phone' => '022-87654321',
                'address' => 'Jl. Raya Lembang No. 666, Bandung',
                'payment_term_days' => 14,
                'current_payable' => 0,
                'is_active' => true,
            ],
            [
                'code' => 'SUP-006',
                'name' => 'CV Mitra Pakan Ternak',
                'company_name' => 'CV Mitra Pakan Ternak',
                'contact_person' => 'Andi Setiawan',
                'email' => 'info@mitrapakan.com',
                'phone' => '0274-123456',
                'address' => 'Jl. Solo KM 8, Yogyakarta',
                'payment_term_days' => 7,
                'current_payable' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::create($supplierData);
        }
    }
    
    private function seedCustomers()
    {
        $customers = [
            [
                'code' => 'CUST-001',
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone' => '081234567890',
                'address' => 'Jl. Raya No. 123, Jakarta Timur',
                'livestock_type' => 'Ayam Broiler',
                'livestock_count' => 1000,
                'customer_type' => 'wholesale',
                'credit_limit' => 10000000,
                'current_debt' => 2500000,
                'allow_credit' => true,
                'payment_term_days' => 30,
                'loyalty_points' => 150,
                'total_purchases' => 25000000,
                'last_purchase_date' => now()->subDays(5),
                'is_active' => true,
            ],
            [
                'code' => 'CUST-002',
                'name' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'phone' => '081234567891',
                'address' => 'Jl. Mawar No. 45, Bogor',
                'livestock_type' => 'Sapi Perah',
                'livestock_count' => 50,
                'customer_type' => 'wholesale',
                'credit_limit' => 15000000,
                'current_debt' => 5000000,
                'allow_credit' => true,
                'payment_term_days' => 45,
                'loyalty_points' => 200,
                'total_purchases' => 45000000,
                'last_purchase_date' => now()->subDays(3),
                'is_active' => true,
            ],
            [
                'code' => 'CUST-003',
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad@example.com',
                'phone' => '081234567892',
                'address' => 'Jl. Melati No. 67, Depok',
                'livestock_type' => 'Kambing',
                'livestock_count' => 25,
                'customer_type' => 'retail',
                'credit_limit' => 2000000,
                'current_debt' => 0,
                'allow_credit' => false,
                'payment_term_days' => 0,
                'loyalty_points' => 50,
                'total_purchases' => 3500000,
                'last_purchase_date' => now()->subDays(10),
                'is_active' => true,
            ],
            [
                'code' => 'CUST-004',
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'phone' => '081234567893',
                'address' => 'Jl. Anggrek No. 89, Tangerang',
                'livestock_type' => 'Ayam Layer',
                'livestock_count' => 500,
                'customer_type' => 'wholesale',
                'credit_limit' => 8000000,
                'current_debt' => 1200000,
                'allow_credit' => true,
                'payment_term_days' => 30,
                'loyalty_points' => 120,
                'total_purchases' => 18000000,
                'last_purchase_date' => now()->subDays(2),
                'is_active' => true,
            ],
            [
                'code' => 'CUST-005',
                'name' => 'Rudi Hermawan',
                'email' => 'rudi@example.com',
                'phone' => '081234567894',
                'address' => 'Jl. Kenanga No. 12, Bekasi',
                'livestock_type' => 'Ayam Kampung',
                'livestock_count' => 100,
                'customer_type' => 'retail',
                'credit_limit' => 1000000,
                'current_debt' => 0,
                'allow_credit' => false,
                'payment_term_days' => 0,
                'loyalty_points' => 30,
                'total_purchases' => 2200000,
                'last_purchase_date' => now()->subDays(7),
                'is_active' => true,
            ],
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }
    }
    
    private function seedProducts()
    {
        $categories = Category::all()->keyBy('slug');
        $units = Unit::all()->keyBy('symbol');

        $products = [
            [
                'code' => 'PAK-001',
                'name' => 'Pakan Ayam Broiler Starter',
                'slug' => 'pakan-ayam-broiler-starter',
                'description' => 'Pakan ayam broiler umur 0-3 minggu dengan protein tinggi',
                'category_id' => $categories['pakan-ayam']->id,
                'unit_id' => $units['kg']->id,
                'stock_quantity' => 500,
                'minimum_stock' => 50,
                'purchase_price' => 8500,
                'selling_price' => 9500,
                'wholesale_price' => 9000,
                'wholesale_min_qty' => 100,
                'brand' => 'Charoen Pokphand',
                'location' => 'Rak A1',
                'track_stock' => true,
                'is_active' => true,
            ],
            [
                'code' => 'PAK-002',
                'name' => 'Pakan Ayam Layer',
                'slug' => 'pakan-ayam-layer',
                'description' => 'Pakan ayam petelur dewasa untuk produksi telur optimal',
                'category_id' => $categories['pakan-ayam']->id,
                'unit_id' => $units['kg']->id,
                'stock_quantity' => 750,
                'minimum_stock' => 75,
                'purchase_price' => 7800,
                'selling_price' => 8800,
                'wholesale_price' => 8300,
                'wholesale_min_qty' => 200,
                'brand' => 'Japfa',
                'location' => 'Rak A2',
                'track_stock' => true,
                'is_active' => true,
            ],
            [
                'code' => 'PAK-003',
                'name' => 'Konsentrat Sapi Perah',
                'slug' => 'konsentrat-sapi-perah',
                'description' => 'Konsentrat untuk sapi perah produktif',
                'category_id' => $categories['pakan-sapi']->id,
                'unit_id' => $units['kg']->id,
                'stock_quantity' => 1000,
                'minimum_stock' => 100,
                'purchase_price' => 4500,
                'selling_price' => 5200,
                'wholesale_price' => 4800,
                'wholesale_min_qty' => 500,
                'brand' => 'Cargill',
                'location' => 'Rak B1',
                'track_stock' => true,
                'is_active' => true,
            ],
            [
                'code' => 'OBT-001',
                'name' => 'Antibiotik Ternak',
                'slug' => 'antibiotik-ternak',
                'description' => 'Antibiotik untuk pengobatan infeksi ternak',
                'category_id' => $categories['obat-obatan']->id,
                'unit_id' => $units['btl']->id,
                'stock_quantity' => 25,
                'minimum_stock' => 5,
                'purchase_price' => 45000,
                'selling_price' => 55000,
                'brand' => 'Medion',
                'location' => 'Rak C1',
                'has_expiry' => true,
                'expiry_date' => now()->addMonths(18),
                'batch_number' => 'MED2024001',
                'usage_instructions' => 'Dosis: 1ml per 10kg berat badan, 2x sehari',
                'track_stock' => true,
                'is_active' => true,
            ],
            [
                'code' => 'VIT-001',
                'name' => 'Vitamin B Complex',
                'slug' => 'vitamin-b-complex',
                'description' => 'Vitamin B kompleks untuk ternak',
                'category_id' => $categories['vitamin-suplemen']->id,
                'unit_id' => $units['tab']->id,
                'stock_quantity' => 500,
                'minimum_stock' => 50,
                'purchase_price' => 500,
                'selling_price' => 750,
                'wholesale_price' => 650,
                'wholesale_min_qty' => 100,
                'brand' => 'Sanbe',
                'location' => 'Rak C2',
                'has_expiry' => true,
                'expiry_date' => now()->addMonths(24),
                'batch_number' => 'SAN2024001',
                'usage_instructions' => '1 tablet per hari dicampur pakan',
                'track_stock' => true,
                'is_active' => true,
            ],
            [
                'code' => 'VIT-002',
                'name' => 'Elektrolit Sachet',
                'slug' => 'elektrolit-sachet',
                'description' => 'Elektrolit untuk mengatasi dehidrasi ternak',
                'category_id' => $categories['vitamin-suplemen']->id,
                'unit_id' => $units['sct']->id,
                'stock_quantity' => 200,
                'minimum_stock' => 20,
                'purchase_price' => 2500,
                'selling_price' => 3500,
                'wholesale_price' => 3000,
                'wholesale_min_qty' => 50,
                'brand' => 'Romindo',
                'location' => 'Rak C3',
                'has_expiry' => true,
                'expiry_date' => now()->addMonths(12),
                'batch_number' => 'ROM2024001',
                'usage_instructions' => '1 sachet untuk 10 liter air minum',
                'track_stock' => true,
                'is_active' => true,
            ],
            [
                'code' => 'PRL-001',
                'name' => 'Tempat Pakan Ayam',
                'slug' => 'tempat-pakan-ayam',
                'description' => 'Tempat pakan plastik untuk ayam',
                'category_id' => $categories['peralatan-kandang']->id,
                'unit_id' => $units['pcs']->id,
                'stock_quantity' => 50,
                'minimum_stock' => 10,
                'purchase_price' => 15000,
                'selling_price' => 20000,
                'wholesale_price' => 18000,
                'wholesale_min_qty' => 10,
                'brand' => 'Maspion',
                'location' => 'Rak D1',
                'track_stock' => true,
                'is_active' => true,
            ],
            [
                'code' => 'DIS-001',
                'name' => 'Desinfektan Kandang',
                'slug' => 'desinfektan-kandang',
                'description' => 'Desinfektan untuk pembersihan kandang',
                'category_id' => $categories['desinfektan']->id,
                'unit_id' => $units['L']->id,
                'stock_quantity' => 60,
                'minimum_stock' => 12,
                'purchase_price' => 18000,
                'selling_price' => 25000,
                'wholesale_price' => 22000,
                'wholesale_min_qty' => 10,
                'brand' => 'Antisep',
                'location' => 'Rak E1',
                'has_expiry' => true,
                'expiry_date' => now()->addMonths(36),
                'batch_number' => 'ANT2024001',
                'usage_instructions' => 'Encerkan 1:100 dengan air bersih',
                'track_stock' => true,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
    
    private function seedTransactions()
    {
        $user = User::first();
        $customers = Customer::all();
        $products = Product::all();

        // Buat 15 transaksi dummy untuk 7 hari terakhir
        for ($i = 0; $i < 15; $i++) {
            $customer = $customers->random();
            $randomDate = Carbon::now()->subDays(rand(0, 6));
            
            $transaction = Transaction::create([
                'transaction_number' => 'TRX-' . $randomDate->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                'customer_id' => rand(1, 10) > 3 ? $customer->id : null, // 70% ada customer
                'user_id' => $user->id,
                'subtotal' => 0,
                'discount_amount' => 0,
                'tax_amount' => 0,
                'total_amount' => 0,
                'paid_amount' => 0,
                'change_amount' => 0,
                'payment_method' => collect(['cash', 'transfer', 'qris'])->random(),
                'payment_status' => 'paid',
                'status' => 'completed',
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            // Tambahkan 1-4 item per transaksi
            $itemCount = rand(1, 4);
            $subtotal = 0;

            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 5);
                $unitPrice = $product->selling_price;
                $itemSubtotal = $quantity * $unitPrice;
                $subtotal += $itemSubtotal;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_code' => $product->code,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'discount_amount' => 0,
                    'subtotal' => $itemSubtotal,
                    'batch_number' => $product->batch_number,
                    'expiry_date' => $product->expiry_date,
                ]);
            }

            // Update total transaksi
            $transaction->update([
                'subtotal' => $subtotal,
                'total_amount' => $subtotal,
                'paid_amount' => $subtotal,
            ]);
        }
    }
}