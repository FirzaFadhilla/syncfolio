<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. PANGGIL SKILL SEEDER ANDA DI SINI
        $this->call([
            SkillSeeder::class,
        ]);

        // 2. BARU BUAT AKUN PENGGUNA
        User::updateOrCreate(
            ['email' => 'admin@syncfolio.com'], 
            [
                'name' => 'Administrator SyncFolio',
                'username' => 'admin',
                'email' => 'admin@syncfolio.com',
                'password' => Hash::make('admin123'), 
                'is_admin' => true,                  
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'fiqar@gmail.com'],
            [
                'name' => 'fiqar',
                'username' => 'fiqar',
                'email' => 'fiqar@gmail.com',
                'password' => Hash::make('password'), 
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );
    }
}