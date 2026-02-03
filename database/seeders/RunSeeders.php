<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RunSeeders extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run all seeders with proper error handling and progress tracking.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting comprehensive database seeding...');
        
        // Disable foreign key checks temporarily
        Schema::disableForeignKeyConstraints();
        
        $seeders = [
            'UserSeeder' => '👤 Creating users...',
            'CategorySeeder' => '📂 Creating categories...',
            'UnitSeeder' => '📏 Creating units...',
            'SupplierSeeder' => '🏭 Creating suppliers...',
            'CustomerSeeder' => '👥 Creating customers...',
            'ProductSeeder' => '📦 Creating products...',
            'ProductUnitSeeder' => '🔄 Creating product units...',
            'PurchaseSeeder' => '🛒 Creating purchases...',
            'TransactionSeeder' => '💰 Creating transactions...',
            'PaymentSeeder' => '💳 Creating payments...',
            'CashierShiftSeeder' => '⏰ Creating cashier shifts...',
        ];

        $totalSeeders = count($seeders);
        $currentSeeder = 0;

        foreach ($seeders as $seederClass => $message) {
            $currentSeeder++;
            $this->command->info("[$currentSeeder/$totalSeeders] $message");
            
            try {
                $this->call($seederClass);
                $this->command->info("✅ $seederClass completed successfully");
            } catch (\Exception $e) {
                $this->command->error("❌ Error in $seederClass: " . $e->getMessage());
                $this->command->error("Stack trace: " . $e->getTraceAsString());
                
                // Continue with other seeders
                continue;
            }
        }
        
        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
        
        $this->command->info('');
        $this->command->info('🎉 Database seeding completed!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info('- Users: ' . DB::table('users')->count());
        $this->command->info('- Categories: ' . DB::table('categories')->count());
        $this->command->info('- Units: ' . DB::table('units')->count());
        $this->command->info('- Suppliers: ' . DB::table('suppliers')->count());
        $this->command->info('- Customers: ' . DB::table('customers')->count());
        $this->command->info('- Products: ' . DB::table('products')->count());
        $this->command->info('- Product Units: ' . DB::table('product_units')->count());
        $this->command->info('- Purchases: ' . DB::table('purchases')->count());
        $this->command->info('- Transactions: ' . DB::table('transactions')->count());
        $this->command->info('- Payments: ' . DB::table('payments')->count());
        $this->command->info('- Cashier Shifts: ' . DB::table('cashier_shifts')->count());
        $this->command->info('');
        $this->command->info('🔑 Login credentials:');
        $this->command->info('- Admin: admin@pos.com / password');
        $this->command->info('- Kasir 1: kasir1@pos.com / password');
        $this->command->info('- Kasir 2: kasir2@pos.com / password');
        $this->command->info('- Manager: manager@pos.com / password');
        $this->command->info('');
        $this->command->info('🎯 Your POS system is ready to use!');
    }
}