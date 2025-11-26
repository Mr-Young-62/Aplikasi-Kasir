<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['nama_level' => 'Administrator'],
            ['nama_level' => 'Waiter'],
            ['nama_level' => 'Kasir'],
            ['nama_level' => 'Owner'],
            ['nama_level' => 'Pelanggan'],
        ];

        foreach ($levels as $level) {
            Level::firstOrCreate($level);
        }

        $this->command->info('Levels created successfully!');
    }
}
