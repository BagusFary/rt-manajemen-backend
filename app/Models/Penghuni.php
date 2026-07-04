<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;

    protected $table = 'penghuni';
    protected $fillable = [
        'nama_lengkap',
        'foto_ktp',
        'status_penghuni',
        'nomor_telepon',
        'status_pernikahan',
    ];

    public function riwayatPenghuni()
    {
        return $this->hasMany(RiwayatPenghuni::class, 'penghuni_id');
    }

    public function pembayaranIuran()
    {
        return $this->hasMany(PembayaranIuran::class, 'penghuni_id');
    }
}