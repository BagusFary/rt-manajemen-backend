<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rumah;
use App\Models\Penghuni;
use App\Models\RiwayatPenghuni;
use Carbon\Carbon;

class RiwayatPenghuniSeeder extends Seeder
{
    public function run(): void
    {
        // Data penghuni tetap yang masih aktif
        for ($i = 1; $i <= 15; $i++) {
            RiwayatPenghuni::create([
                'rumah_id' => $i,
                'penghuni_id' => $i,
                'tanggal_masuk' => Carbon::now()->subMonths(18)->format('Y-m-d'),
                'tanggal_keluar' => null,
            ]);
        }

        // Data penghuni kontrak yang masih aktif
        for ($i = 16; $i <= 18; $i++) {
            RiwayatPenghuni::create([
                'rumah_id' => $i,
                'penghuni_id' => $i,
                'tanggal_masuk' => Carbon::now()->subMonths(6)->format('Y-m-d'),
                'tanggal_keluar' => null,
            ]);
        }

        // Riwayat penghuni yang sudah pindah
        for ($i = 19; $i <= 20; $i++) {
            RiwayatPenghuni::create([
                'rumah_id' => $i,
                'penghuni_id' => $i,
                'tanggal_masuk' => Carbon::now()->subMonths(12)->format('Y-m-d'),
                'tanggal_keluar' => Carbon::now()->subMonths(5)->format('Y-m-d'),
            ]);
        }
    } 
}