<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LevelSeeder::class,
            DemoDataSeeder::class,
            SampleDataSeeder::class,
        ]);

        // Create demo users for each role
        $demoUsers = [
            [
                'username' => 'admin',
                'name' => 'Administrator',
                'email' => 'admin@resto.com',
                'password' => 'password',
                'role' => 'Administrator',
            ],
            [
                'username' => 'waiter1',
                'name' => 'Waiter 1',
                'email' => 'waiter1@resto.com',
                'password' => 'password',
                'role' => 'Waiter',
            ],
            [
                'username' => 'kasir1',
                'name' => 'Kasir 1',
                'email' => 'kasir1@resto.com',
                'password' => 'password',
                'role' => 'Kasir',
            ],
            [
                'username' => 'owner',
                'name' => 'Owner',
                'email' => 'owner@resto.com',
                'password' => 'password',
                'role' => 'Owner',
            ],
            [
                'username' => 'customer1',
                'name' => 'Customer 1',
                'email' => 'customer1@resto.com',
                'password' => 'password',
                'role' => 'Pelanggan',
            ],
        ];

        foreach ($demoUsers as $userData) {
            $level = Level::where('nama_level', $userData['role'])->first();
            
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'username' => $userData['username'],
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'id_level' => $level->id_level,
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('Demo users created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@resto.com / password');
        $this->command->info('Waiter: waiter1@resto.com / password');
        $this->command->info('Kasir: kasir1@resto.com / password');
        $this->command->info('Owner: owner@resto.com / password');
        $this->command->info('Pelanggan: customer1@resto.com / password');
    }
}
