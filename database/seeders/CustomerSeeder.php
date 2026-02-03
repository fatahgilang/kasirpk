<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'code' => 'CUST-001',
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone' => '081234567890',
                'address' => 'Jl. Raya No. 123, Jakarta',
                'livestock_type' => 'Ayam Broiler',
                'livestock_count' => 1000,
                'customer_type' => 'wholesale',
                'credit_limit' => 10000000,
                'allow_credit' => true,
                'payment_term_days' => 30,
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
                'allow_credit' => true,
                'payment_term_days' => 45,
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
                'allow_credit' => false,
                'payment_term_days' => 0,
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
                'allow_credit' => true,
                'payment_term_days' => 30,
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
                'allow_credit' => false,
                'payment_term_days' => 0,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
