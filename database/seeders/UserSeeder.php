<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Kaur Pemerintahan',
                'username' => 'kaur_pemerintahan',
                'email' => 'kaur.pemerintahan@desalesane.id',
                'password' => Hash::make('kaur123'),
                'tipe' => 'operator',
                'aktif' => true,
                'last_login_at' => now()->subDays(rand(1, 7)),
            ],
            [
                'name' => 'Kaur Kesejahteraan',
                'username' => 'kaur_kesra',
                'email' => 'kaur.kesra@desalesane.id',
                'password' => Hash::make('kaur123'),
                'tipe' => 'operator',
                'aktif' => true,
                'last_login_at' => now()->subDays(rand(1, 7)),
            ],
            [
                'name' => 'Kaur Umum',
                'username' => 'kaur_umum',
                'email' => 'kaur.umum@desalesane.id',
                'password' => Hash::make('kaur123'),
                'tipe' => 'operator',
                'aktif' => true,
                'last_login_at' => now()->subDays(rand(1, 7)),
            ],
            [
                'name' => 'Bendahara Desa',
                'username' => 'bendahara',
                'email' => 'bendahara@desalesane.id',
                'password' => Hash::make('bendahara123'),
                'tipe' => 'operator',
                'aktif' => true,
                'last_login_at' => now()->subDays(rand(1, 7)),
            ],
            [
                'name' => 'Staff IT',
                'username' => 'staff_it',
                'email' => 'it@desalesane.id',
                'password' => Hash::make('staff123'),
                'tipe' => 'operator',
                'aktif' => true,
                'last_login_at' => now()->subHours(rand(1, 48)),
            ],
        ];

        foreach ($users as $user) {
            // Cek apakah user sudah ada berdasarkan username
            if (!User::where('username', $user['username'])->exists()) {
                User::create($user);
            }
        }

        // Update user yang sudah ada dengan last_login_at
        User::where('username', 'superadmin')->update(['last_login_at' => now()]);
        User::where('username', 'operator')->update(['last_login_at' => now()->subHours(3)]);
        User::where('username', 'kades')->update(['last_login_at' => now()->subDays(1)]);

        $this->command->info('✅ Berhasil membuat ' . count($users) . ' user tambahan');
        $this->command->info('ℹ️  Password default: kaur123, bendahara123, staff123');
    }
}
