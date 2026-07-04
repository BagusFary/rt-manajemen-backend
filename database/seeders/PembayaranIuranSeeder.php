<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiwayatPenghuni;
use App\Models\PembayaranIuran;
use Carbon\Carbon;

class PembayaranIuranSeeder extends Seeder
{
    public function run(): void
    {
        $sekarang = Carbon::now();

        // Seed data mundur 12 bulan terakhir
        for ($m = 11; $m >= 0; $m--) {
            $targetBulan = $sekarang->copy()->subMonths($m);
            $bulanAngka = $targetBulan->month;
            $tahunAngka = $targetBulan->year;

            $penghuniAktifBulanIni = RiwayatPenghuni::where(function ($query) use ($targetBulan) {
                $query->where('tanggal_masuk', '<=', $targetBulan->endOfMonth()->format('Y-m-d'))
                      ->where(function ($q) use ($targetBulan) {
                          $q->whereNull('tanggal_keluar')
                            ->orWhere('tanggal_keluar', '>=', $targetBulan->startOfMonth()->format('Y-m-d'));
                      });
            })->get();

            foreach ($penghuniAktifBulanIni as $huni) {
                
                $isLunasSatpam = !($m == 0 && $huni->rumah_id % 2 != 0);

                PembayaranIuran::create([
                    'rumah_id' => $huni->rumah_id,
                    'penghuni_id' => $huni->penghuni_id,
                    'jenis_iuran' => 'satpam',
                    'bulan' => $bulanAngka,
                    'tahun' => $tahunAngka,
                    'jumlah_bayar' => 100000,
                    'status_pembayaran' => $isLunasSatpam ? 'lunas' : 'belum_lunas',
                    'tanggal_bayar' => $isLunasSatpam ? $targetBulan->copy()->day(rand(1, 10))->toDateTimeString() : null,
                ]);

                $apakahBayarTahunan = in_array($huni->rumah_id, [1, 2, 3]);

                // Warga bayar tahunan
                if ($apakahBayarTahunan) {
                    PembayaranIuran::create([
                        'rumah_id' => $huni->rumah_id,
                        'penghuni_id' => $huni->penghuni_id,
                        'jenis_iuran' => 'kebersihan',
                        'bulan' => $bulanAngka,
                        'tahun' => $tahunAngka,
                        'jumlah_bayar' => 15000,
                        'status_pembayaran' => 'lunas',
                        'tanggal_bayar' => Carbon::create($tahunAngka, 1, 5, 10, 0, 0)->toDateTimeString(),
                    ]);
                } else {
                    // Warga lainnya bayar bulanan seperti biasa
                    $isLunasKebersihan = !($m == 0 && $huni->rumah_id % 3 == 0);

                    PembayaranIuran::create([
                        'rumah_id' => $huni->rumah_id,
                        'penghuni_id' => $huni->penghuni_id,
                        'jenis_iuran' => 'kebersihan',
                        'bulan' => $bulanAngka,
                        'tahun' => $tahunAngka,
                        'jumlah_bayar' => 15000,
                        'status_pembayaran' => $isLunasKebersihan ? 'lunas' : 'belum_lunas',
                        'tanggal_bayar' => $isLunasKebersihan ? $targetBulan->copy()->day(rand(1, 10))->toDateTimeString() : null,
                    ]);
                }
            }
        }
    }
}