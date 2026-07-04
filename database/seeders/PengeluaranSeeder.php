<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengeluaran;
use Carbon\Carbon;

class PengeluaranSeeder extends Seeder
{
    public function run(): void
    {
        $sekarang = Carbon::now();

        // Seed data pengeluaran selama 12 bulan terakhir.
        for ($m = 11; $m >= 0; $m--) {
            $targetBulan = $sekarang->copy()->subMonths($m);
            $bulanAngka = $targetBulan->month;

            Pengeluaran::create([
                'deskripsi' => 'Gaji Bulanan Satpam Perumahan',
                'jumlah' => 1200000,
                'tanggal_pengeluaran' => $targetBulan->copy()->day(25)->format('Y-m-d'),
            ]);

            Pengeluaran::create([
                'deskripsi' => 'Biaya Token Listrik Pos Satpam',
                'jumlah' => 150000,
                'tanggal_pengeluaran' => $targetBulan->copy()->day(2)->format('Y-m-d'),
            ]);

            if ($bulanAngka == 3 || $bulanAngka == 8) {
                Pengeluaran::create([
                    'deskripsi' => 'Perbaikan Selokan Blok A',
                    'jumlah' => 450000,
                    'tanggal_pengeluaran' => $targetBulan->copy()->day(12)->format('Y-m-d'),
                ]);
            }

            if ($bulanAngka == 6) {
                Pengeluaran::create([
                    'deskripsi' => 'Perbaikan Aspal Jalan Depan Pos Utama',
                    'jumlah' => 850000,
                    'tanggal_pengeluaran' => $targetBulan->copy()->day(18)->format('Y-m-d'),
                ]);
            }
        }
    }
}