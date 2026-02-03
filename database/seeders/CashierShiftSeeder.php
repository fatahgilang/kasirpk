<?php

namespace Database\Seeders;

use App\Models\CashierShift;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CashierShiftSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Buat shift kasir untuk 7 hari terakhir
        for ($day = 6; $day >= 0; $day--) {
            $date = Carbon::now()->subDays($day);
            
            // Shift pagi (08:00 - 16:00)
            $morningUser = $users->random();
            $morningStart = $date->copy()->setTime(8, 0);
            $morningEnd = $date->copy()->setTime(16, 0);
            
            CashierShift::create([
                'user_id' => $morningUser->id,
                'shift_name' => 'Shift Pagi',
                'start_time' => $morningStart,
                'end_time' => $morningEnd,
                'opening_balance' => 500000, // Saldo awal 500rb
                'closing_balance' => rand(800000, 1500000), // Saldo akhir random
                'total_sales' => rand(300000, 1000000),
                'total_transactions' => rand(15, 40),
                'cash_in_drawer' => rand(800000, 1500000),
                'notes' => 'Shift pagi berjalan normal',
                'status' => 'closed',
                'created_at' => $morningStart,
                'updated_at' => $morningEnd,
            ]);

            // Shift sore (16:00 - 22:00) - hanya hari kerja
            if ($date->isWeekday()) {
                $eveningUser = $users->where('id', '!=', $morningUser->id)->random();
                $eveningStart = $date->copy()->setTime(16, 0);
                $eveningEnd = $date->copy()->setTime(22, 0);
                
                CashierShift::create([
                    'user_id' => $eveningUser->id,
                    'shift_name' => 'Shift Sore',
                    'start_time' => $eveningStart,
                    'end_time' => $eveningEnd,
                    'opening_balance' => rand(800000, 1500000), // Dari shift sebelumnya
                    'closing_balance' => rand(1000000, 2000000),
                    'total_sales' => rand(200000, 800000),
                    'total_transactions' => rand(10, 25),
                    'cash_in_drawer' => rand(1000000, 2000000),
                    'notes' => 'Shift sore, transaksi lebih sedikit',
                    'status' => 'closed',
                    'created_at' => $eveningStart,
                    'updated_at' => $eveningEnd,
                ]);
            }
        }

        // Buat shift yang sedang aktif (hari ini)
        $today = Carbon::now();
        $activeUser = $users->random();
        $shiftStart = $today->copy()->setTime(8, 0);
        
        CashierShift::create([
            'user_id' => $activeUser->id,
            'shift_name' => 'Shift Pagi',
            'start_time' => $shiftStart,
            'end_time' => null,
            'opening_balance' => 500000,
            'closing_balance' => null,
            'total_sales' => rand(100000, 300000), // Sales sementara
            'total_transactions' => rand(5, 15),
            'cash_in_drawer' => null,
            'notes' => 'Shift sedang berlangsung',
            'status' => 'active',
            'created_at' => $shiftStart,
            'updated_at' => now(),
        ]);
    }
}