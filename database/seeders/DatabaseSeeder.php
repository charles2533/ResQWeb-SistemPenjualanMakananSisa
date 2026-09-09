<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin ResQ',
            'email' => 'admin@resq.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Seller (Pak Budi)
        $seller = User::create([
            'name' => 'Pak Budi',
            'email' => 'budi@resq.com',
            'password' => Hash::make('password123'),
            'role' => 'seller',
            'store_name' => 'Warung Nasi Pak Budi Ketintang',
            'address' => 'Jl. Ketintang Madya No. 12, Surabaya',
        ]);

        // 3. Buat Akun Customer (Agus)
        $customer = User::create([
            'name' => 'Agus Mahasiswa',
            'email' => 'agus@resq.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

    }
}
