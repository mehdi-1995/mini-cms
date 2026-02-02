<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = 123456;
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@example.com'], // ایمیل ثابت برای شناسایی
            [
            'name' => 'Super Admin',
            'password' => Hash::make($password),
            ]
        );
        $admin->assignRole('super-admin');
    }
}
