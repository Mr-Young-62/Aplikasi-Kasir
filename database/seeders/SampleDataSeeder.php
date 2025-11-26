<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Masakan;
use App\Models\Meja;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        DB::statement('PRAGMA foreign_keys = OFF');
        
        // Clear existing data
        Order::query()->delete();
        DetailOrder::query()->delete();
        Transaksi::query()->delete();
        
        // Get sample data
        $waiters = User::whereHas('level', function($q) {
            $q->where('nama_level', 'Waiter');
        })->get();
        
        $masakans = Masakan::all();
        $mejas = Meja::all();
        
        if ($waiters->isEmpty() || $masakans->isEmpty() || $mejas->isEmpty()) {
            echo "Missing required data for sample seeding\n";
            return;
        }
        
        // Create sample orders for the last 30 days
        for ($i = 0; $i < 50; $i++) {
            $orderDate = Carbon::now()->subDays(rand(0, 30));
            $waiter = $waiters->random();
            $meja = $mejas->random();
            
            // Create order
            $order = Order::create([
                'id_user' => $waiter->id,
                'no_meja' => $meja->no_meja,
                'tanggal' => $orderDate,
                'status_order' => ['selesai', 'diproses', 'selesai'][rand(0, 2)],
                'total_harga' => 0, // Will be calculated
            ]);
            
            // Add 2-5 random items to order
            $totalHarga = 0;
            $numItems = rand(2, 5);
            $selectedMasakans = $masakans->random($numItems);
            
            foreach ($selectedMasakans as $masakan) {
                $jumlah = rand(1, 3);
                $subtotal = $masakan->harga * $jumlah;
                $totalHarga += $subtotal;
                
                DetailOrder::create([
                    'id_order' => $order->id_order,
                    'id_masakan' => $masakan->id_masakan,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $masakan->harga,
                    'subtotal' => $subtotal,
                ]);
            }
            
            // Update order total
            $order->update(['total_harga' => $totalHarga]);
            
            // Create transaction for completed orders
            if ($order->status_order === 'selesai' && rand(0, 1)) {
                // Get kasir user for transaction
                $kasir = User::whereHas('level', function($q) {
                    $q->where('nama_level', 'Kasir');
                })->first();
                
                if ($kasir) {
                    Transaksi::create([
                        'id_user' => $kasir->id,
                        'id_order' => $order->id_order,
                        'tanggal' => $orderDate->addMinutes(rand(30, 120)),
                        'total_bayar' => $totalHarga,
                        'uang_bayar' => $totalHarga + rand(1000, 10000),
                        'kembalian' => rand(1000, 10000),
                        'status_transaksi' => 'berhasil',
                    ]);
                }
            }
        }
        
        // Re-enable foreign key checks
        DB::statement('PRAGMA foreign_keys = ON');
        
        echo "Sample orders and transactions created successfully!\n";
        echo "Orders: " . Order::count() . "\n";
        echo "Transactions: " . Transaksi::count() . "\n";
    }
}
