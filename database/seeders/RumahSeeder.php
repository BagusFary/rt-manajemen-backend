<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rumah;

class RumahSeeder extends Seeder
{
    public function run(): void
    {
        // 15 Rumah Dihuni Tetap
        for ($i = 1; $i <= 15; $i++) {
            Rumah::create([
                'nomor_rumah' => 'Blok A-' . sprintf('%02d', $i),
                'status_rumah' => 'dihuni',
            ]);
        }

        // 5 Rumah Lainnya (3 Dihuni Kontrak, 2 Kosong)
        for ($i = 16; $i <= 20; $i++) {
            Rumah::create([
                'nomor_rumah' => 'Blok B-' . sprintf('%02d', $i - 15),
                'status_rumah' => $i <= 18 ? 'dihuni' : 'tidak_dihuni',
            ]);
        }
    }
}
