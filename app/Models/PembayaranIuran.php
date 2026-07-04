<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranIuran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_iuran';

    protected $fillable = [
        'rumah_id',
        'penghuni_id',
        'jenis_iuran',
        'bulan',
        'tahun',
        'jumlah_bayar',
        'status_pembayaran',
        'tanggal_bayar',
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'penghuni_id');
    }
}