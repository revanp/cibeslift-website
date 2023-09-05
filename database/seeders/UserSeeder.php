<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.io',
            'password' => bcrypt('123456'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
