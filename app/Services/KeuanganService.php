<?php

namespace App\Services;

use App\Repositories\Contracts\PembayaranIuranRepositoryInterface;
use App\Repositories\Contracts\PengeluaranRepositoryInterface;
use Carbon\Carbon;

class KeuanganService
{
    protected $pembayaranRepo;
    protected $pengeluaranRepo;

    public function __construct(
        PembayaranIuranRepositoryInterface $pembayaranRepo,
        PengeluaranRepositoryInterface $pengeluaranRepo
    ) {
        $this->pembayaranRepo = $pembayaranRepo;
        $this->pengeluaranRepo = $pengeluaranRepo;
    }

    public function bayarIuran(array $data)
    {
        $nominal = $data['jenis_iuran'] == 'satpam' ? 100000 : 15000; 
        
        if (isset($data['bayar_setahun']) && $data['bayar_setahun'] == true) {
            $hasilBulk = [];
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $hasilBulk[] = $this->pembayaranRepo->create([
                    'rumah_id' => $data['rumah_id'],
                    'penghuni_id' => $data['penghuni_id'],
                    'jenis_iuran' => $data['jenis_iuran'],
                    'bulan' => $bulan,
                    'tahun' => $data['tahun'],
                    'jumlah_bayar' => $nominal,
                    'status_pembayaran' => 'lunas',
                    'tanggal_bayar' => Carbon::now()->toDateTimeString(),
                ]);
            }
            return $hasilBulk;
        }

        return $this->pembayaranRepo->create([
            'rumah_id' => $data['rumah_id'],
            'penghuni_id' => $data['penghuni_id'],
            'jenis_iuran' => $data['jenis_iuran'],
            'bulan' => $data['bulan'],
            'tahun' => $data['tahun'],
            'jumlah_bayar' => $nominal,
            'status_pembayaran' => 'lunas',
            'tanggal_bayar' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function catatPengeluaran(array $data)
    {
        return $this->pengeluaranRepo->create($data);
    }

    public function getSummaryTahunan(int $tahun)
    {
        $pemasukan = $this->pembayaranRepo->getTotalPemasukanPerBulan($tahun);
        $pengeluaran = $this->pengeluaranRepo->getTotalPengeluaranPerBulan($tahun);

        $summary = [];
        $bulanIndo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        for ($i = 1; $i <= 12; $i++) {
            $totalMasuk = $pemasukan[$i] ?? 0;
            $totalKeluar = $pengeluaran[$i] ?? 0;
            $saldoSisa = $totalMasuk - $totalKeluar;

            $summary[] = [
                'bulan' => $bulanIndo[$i - 1],
                'pemasukan' => (int) $totalMasuk,
                'pengeluaran' => (int) $totalKeluar,
                'saldo' => (int) $saldoSisa
            ];
        }

        return $summary;
    }

    public function getDetailBulanan(int $bulan, int $tahun)
    {
        $pemasukanDetail = $this->pembayaranRepo->getByBulanTahun($bulan, $tahun);
        $pengeluaranDetail = $this->pengeluaranRepo->getByBulanTahun($bulan, $tahun);

        $totalPemasukan = $pemasukanDetail->where('status_pembayaran', 'lunas')->sum('jumlah_bayar');
        $totalPengeluaran = $pengeluaranDetail->sum('jumlah');

        return [
            'periode' => ['bulan' => $bulan, 'tahun' => $tahun],
            'ringkasan' => [
                'total_pemasukan' => $totalPemasukan,
                'total_pengeluaran' => $totalPengeluaran,
                'saldo_akhir' => $totalPemasukan - $totalPengeluaran
            ],
            'detail_pemasukan' => $pemasukanDetail,
            'detail_pengeluaran' => $pengeluaranDetail
        ];
    }

    public function getHistoryPembayaranByRumah(int $rumahId)
    {
        return $this->pembayaranRepo->getHistoryByRumah($rumahId);
    }
}