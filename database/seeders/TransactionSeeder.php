<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Masakan;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        // Get demo data
        $waiter = User::whereHas('level', function($q) {
            $q->where('nama_level', 'Waiter');
        })->first();
        
        $kasir = User::whereHas('level', function($q) {
            $q->where('nama_level', 'Kasir');
        })->first();

        $masakans = Masakan::all();
        $mejas = Meja::all();

        if (!$waiter || !$kasir || $masakans->isEmpty() || $mejas->isEmpty()) {
            echo "Missing required data for transaction seeding\n";
            return;
        }

        // Create sample orders and transactions for the last few days
        for ($day = 7; $day >= 0; $day--) {
            $date = Carbon::now()->subDays($day);
            
            // Create 2-5 orders per day
            $ordersPerDay = rand(2, 5);
            
            for ($i = 0; $i < $ordersPerDay; $i++) {
                $meja = $mejas->random();
                
                // Create order
                $order = Order::create([
                    'no_meja' => $meja->no_meja,
                    'tanggal' => $date,
                    'id_user' => $waiter->id,
                    'keterangan' => 'Sample order ' . ($i + 1),
                    'status_order' => 'dibayar',
                    'total_harga' => 0, // Will be calculated
                ]);

                // Add random items to order (2-4 items)
                $itemsPerOrder = rand(2, 4);
                $selectedMasakans = $masakans->random($itemsPerOrder);
                
                foreach ($selectedMasakans as $masakan) {
                    $quantity = rand(1, 3);
                    
                    DetailOrder::create([
                        'id_order' => $order->id_order,
                        'id_masakan' => $masakan->id_masakan,
                        'jumlah' => $quantity,
                        'harga_satuan' => $masakan->harga,
                        'subtotal' => $masakan->harga * $quantity,
                        'keterangan' => 'Extra ' . $masakan->nama_masakan,
                    ]);
                }

                // Calculate total
                $order->calculateTotal();

                // Create transaction for some orders (80% chance)
                if (rand(1, 100) <= 80) {
                    $totalBayar = $order->total_harga;
                    $uangBayar = $totalBayar + rand(0, 50000); // Random extra cash
                    
                    Transaksi::create([
                        'id_user' => $kasir->id,
                        'id_order' => $order->id_order,
                        'tanggal' => $date,
                        'total_bayar' => $totalBayar,
                        'uang_bayar' => $uangBayar,
                        'kembalian' => $uangBayar - $totalBayar,
                        'metode_pembayaran' => ['cash', 'transfer', 'kartu', 'ewallet'][rand(0, 3)],
                        'no_referensi' => 'REF' . date('Ymd') . rand(1000, 9999),
                        'status_transaksi' => 'berhasil',
                    ]);
                }
            }
        }

        echo "Sample orders and transactions created successfully!\n";
    }
}
