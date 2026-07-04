<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RumahSeeder;
use Database\Seeders\PenghuniSeeder;
use Database\Seeders\PengeluaranSeeder;
use Database\Seeders\PembayaranIuranSeeder;
use Database\Seeders\RiwayatPenghuniSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        UserSeeder::class,
        RumahSeeder::class,
        PenghuniSeeder::class,
        RiwayatPenghuniSeeder::class,
        PengeluaranSeeder::class,
        PembayaranIuranSeeder::class
    ]);
    }
}
