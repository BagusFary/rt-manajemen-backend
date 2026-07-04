<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenghuni extends Model
{
    use HasFactory;

    protected $table = 'riwayat_penghuni';

    protected $fillable = [
        'rumah_id',
        'penghuni_id',
        'tanggal_masuk',
        'tanggal_keluar',
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