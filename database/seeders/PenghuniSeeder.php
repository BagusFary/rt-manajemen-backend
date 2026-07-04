<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penghuni;

class PenghuniSeeder extends Seeder
{
    public function run(): void
    {
        // 15 Warga Tetap
        for ($i = 1; $i <= 15; $i++) {
            Penghuni::create([
                'nama_lengkap' => 'Warga Tetap ' . $this->getNamaDummy($i),
                'foto_ktp' => 'uploads/ktp/tetap_' . $i . '.jpg',
                'status_penghuni' => 'tetap',
                'nomor_telepon' => '0812345678' . sprintf('%02d', $i),
                'status_pernikahan' => $i % 3 == 0 ? 'belum_menikah' : 'menikah',
            ]);
        }

        // 3 Warga Kontrak Aktif
        for ($i = 16; $i <= 18; $i++) {
            Penghuni::create([
                'nama_lengkap' => 'Warga Kontrak ' . $this->getNamaDummy($i),
                'foto_ktp' => 'uploads/ktp/kontrak_' . $i . '.jpg',
                'status_penghuni' => 'kontrak',
                'nomor_telepon' => '0877654321' . sprintf('%02d', $i),
                'status_pernikahan' => 'belum_menikah',
            ]);
        }

        // 2 Mantan Warga Kontrak
        for ($i = 19; $i <= 20; $i++) {
            Penghuni::create([
                'nama_lengkap' => 'Mantan Penghuni ' . $this->getNamaDummy($i),
                'foto_ktp' => 'uploads/ktp/mantan_' . $i . '.jpg',
                'status_penghuni' => 'kontrak',
                'nomor_telepon' => '0899999999' . sprintf('%02d', $i),
                'status_pernikahan' => 'menikah',
            ]);
        }
    }

    private function getNamaDummy($index) {
        $daftarNama = [
            1 => 'Budi Santoso', 2 => 'Ahmad Hidayat', 3 => 'Siti Aminah', 4 => 'Dedi Wijaya',
            5 => 'Eko Prasetyo', 6 => 'Rina Amalia', 7 => 'Heri Setiawan', 8 => 'Dewi Lestari',
            9 => 'Rudi Hartono', 10 => 'Mega Wati', 11 => 'Taufik Hidayat', 12 => 'Sri Wahyuni',
            13 => 'Bambang Utomo', 14 => 'Fitriani', 15 => 'Andi Wijaya', 16 => 'Kevin Sanjaya',
            17 => 'Gisela Anastasia', 18 => 'Joko Susilo', 19 => 'Denny Caknan', 20 => 'ZIdan Rizky'
        ];
        return $daftarNama[$index] ?? 'Warga Baru';
    }
}
