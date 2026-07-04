<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Pak RT Rizal Faizal',
            'email' => 'rt.admin@jagoanhosting.com',
            'password' => bcrypt('password123'),
        ]);
    }
}
