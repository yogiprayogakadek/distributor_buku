<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin',
            'jenis_kelamin' => 'Laki - Laki',
            'telp' => '081234567890',
            'username' => 'admin',
            'password' => bcrypt(12345678),
            'email' => 'administrator@gmail.com',
            'role' => 'Admin',
            'is_active' => true
        ]);
    }
}
