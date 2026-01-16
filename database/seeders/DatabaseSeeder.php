<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat atau memperbarui user admin utama
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Fira',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Memanggil seeder FinalDatabaseSeeder untuk mengisi data lengkap
        // Pastikan file FinalDatabaseSeeder.php sudah Anda buat sebelumnya
        $this->call([
            FinalDatabaseSeeder::class,
        ]);
    }
}
