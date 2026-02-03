<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing suppliers
        Supplier::truncate();
        
        $suppliers = [
            [
                'code' => 'SUP-001',
                'name' => 'PT Charoen Pokphand Indonesia',
                'contact_person' => 'Budi Hartono',
                'email' => 'sales@cpi.co.id',
                'phone' => '021-12345678',
                'address' => 'Jl. Ancol Barat No. 1, Jakarta Utara',
                'supplier_type' => 'manufacturer',
                'payment_term_days' => 30,
                'credit_limit' => 50000000,
                'tax_number' => '01.234.567.8-901.000',
                'bank_name' => 'Bank Mandiri',
                'bank_account' => '1234567890',
                'is_active' => true,
            ],
            [
                'code' => 'SUP-002',
                'name' => 'PT Japfa Comfeed Indonesia',
                'contact_person' => 'Siti Rahayu',
                'email' => 'procurement@japfa.com',
                'phone' => '021-87654321',
                'address' => 'Jl. Letjen S. Parman Kav. 35, Jakarta Barat',
                'supplier_type' => 'manufacturer',
                'payment_term_days' => 45,
                'credit_limit' => 75000000,
                'tax_number' => '02.345.678.9-012.000',
                'bank_name' => 'Bank BCA',
                'bank_account' => '2345678901',
                'is_active' => true,
            ],
            [
                'code' => 'SUP-003',
                'name' => 'PT Cargill Indonesia',
                'contact_person' => 'Ahmad Wijaya',
                'email' => 'sales@cargill.co.id',
                'phone' => '021-11223344',
                'address' => 'Jl. HR Rasuna Said Kav. C-22, Jakarta Selatan',
                'supplier_type' => 'manufacturer',
                'payment_term_days' => 30,
                'credit_limit' => 60000000,
                'tax_number' => '03.456.789.0-123.000',
                'bank_name' => 'Bank BNI',
                'bank_account' => '3456789012',
                'is_active' => true,
            ],
            [
                'code' => 'SUP-004',
                'name' => 'PT Medion Ardhika Bhakti',
                'contact_person' => 'Dr. Dewi Lestari',
                'email' => 'sales@medion.co.id',
                'phone' => '0251-8123456',
                'address' => 'Jl. Raya Bogor KM 27, Cibinong, Bogor',
                'supplier_type' => 'pharmaceutical',
                'payment_term_days' => 21,
                'credit_limit' => 25000000,
                'tax_number' => '04.567.890.1-234.000',
                'bank_name' => 'Bank BRI',
                'bank_account' => '4567890123',
                'is_active' => true,
            ],
            [
                'code' => 'SUP-005',
                'name' => 'PT Sanbe Farma',
                'contact_person' => 'Rudi Hermawan',
                'email' => 'marketing@sanbe.co.id',
                'phone' => '022-87654321',
                'address' => 'Jl. Raya Lembang No. 666, Bandung',
                'supplier_type' => 'pharmaceutical',
                'payment_term_days' => 14,
                'credit_limit' => 15000000,
                'tax_number' => '05.678.901.2-345.000',
                'bank_name' => 'Bank Mandiri',
                'bank_account' => '5678901234',
                'is_active' => true,
            ],
            [
                'code' => 'SUP-006',
                'name' => 'CV Mitra Pakan Ternak',
                'contact_person' => 'Andi Setiawan',
                'email' => 'info@mitrapakan.com',
                'phone' => '0274-123456',
                'address' => 'Jl. Solo KM 8, Yogyakarta',
                'supplier_type' => 'distributor',
                'payment_term_days' => 7,
                'credit_limit' => 10000000,
                'tax_number' => '06.789.012.3-456.000',
                'bank_name' => 'Bank BCA',
                'bank_account' => '6789012345',
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::create($supplierData);
        }
        
        $this->command->info('✅ Suppliers seeded successfully');
    }
}