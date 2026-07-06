<?php

namespace App\Services;

use App\Repositories\Contracts\PembayaranIuranRepositoryInterface;
use App\Repositories\Contracts\PengeluaranRepositoryInterface;
use App\Repositories\Contracts\RiwayatPenghuniRepositoryInterface;
use Carbon\Carbon;

class KeuanganService
{
    protected $pembayaranRepo;
    protected $pengeluaranRepo;
    protected $riwayatRepo;

    public function __construct(
        PembayaranIuranRepositoryInterface $pembayaranRepo,
        PengeluaranRepositoryInterface $pengeluaranRepo,
        RiwayatPenghuniRepositoryInterface $riwayatRepo
    ) {
        $this->pembayaranRepo = $pembayaranRepo;
        $this->pengeluaranRepo = $pengeluaranRepo;
        $this->riwayatRepo = $riwayatRepo;
    }

    public function getAllPengeluaran()
    {
        return $this->pengeluaranRepo->getAll();
    }

    public function bayarIuran(array $data)
    {
        $nominal = $data['jenis_iuran'] == 'satpam' ? 100000 : 15000; 
        
        if (isset($data['bayar_setahun']) && $data['bayar_setahun'] == true) {
            $hasilBulk = [];
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $hasilBulk[] = $this->pembayaranRepo->updateOrCreate(
                    [
                        'rumah_id' => $data['rumah_id'],
                        'jenis_iuran' => $data['jenis_iuran'],
                        'bulan' => $bulan,
                        'tahun' => $data['tahun'],
                    ],
                    [
                        'penghuni_id' => $data['penghuni_id'],
                        'jumlah_bayar' => $nominal,
                        'status_pembayaran' => 'lunas',
                        'tanggal_bayar' => Carbon::now()->toDateTimeString(),
                    ]
                );
            }
            return $hasilBulk;
        }

        return $this->pembayaranRepo->updateOrCreate(
            [
                'rumah_id' => $data['rumah_id'],
                'jenis_iuran' => $data['jenis_iuran'],
                'bulan' => $data['bulan'],
                'tahun' => $data['tahun'],
            ],
            [
                'penghuni_id' => $data['penghuni_id'],
                'jumlah_bayar' => $nominal,
                'status_pembayaran' => 'lunas',
                'tanggal_bayar' => Carbon::now()->toDateTimeString(),
            ]
        );
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

    public function generateTagihanBulanan()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;
        
        $penghuniAktif = \App\Models\RiwayatPenghuni::whereNull('tanggal_keluar')->get(); 
        
        $tagihanDibuat = 0;

        foreach ($penghuniAktif as $huni) {
            
            $cekSatpam = $this->pembayaranRepo->getByBulanTahun($bulanIni, $tahunIni)
                ->where('rumah_id', $huni->rumah_id)
                ->where('jenis_iuran', 'satpam')
                ->first();

            if (!$cekSatpam) {
                $this->pembayaranRepo->create([
                    'rumah_id' => $huni->rumah_id,
                    'penghuni_id' => $huni->penghuni_id,
                    'jenis_iuran' => 'satpam',
                    'bulan' => $bulanIni,
                    'tahun' => $tahunIni,
                    'jumlah_bayar' => 100000,
                    'status_pembayaran' => 'belum_lunas', 
                    'tanggal_bayar' => null,
                ]);
                $tagihanDibuat++;
            }

            $cekKebersihan = $this->pembayaranRepo->getByBulanTahun($bulanIni, $tahunIni)
                ->where('rumah_id', $huni->rumah_id)
                ->where('jenis_iuran', 'kebersihan')
                ->first();

            if (!$cekKebersihan) {
                $this->pembayaranRepo->create([
                    'rumah_id' => $huni->rumah_id,
                    'penghuni_id' => $huni->penghuni_id,
                    'jenis_iuran' => 'kebersihan',
                    'bulan' => $bulanIni,
                    'tahun' => $tahunIni,
                    'jumlah_bayar' => 15000,
                    'status_pembayaran' => 'belum_lunas',
                    'tanggal_bayar' => null,
                ]);
                $tagihanDibuat++;
            }
        }

        return $tagihanDibuat;
    }
}