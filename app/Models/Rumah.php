<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    use HasFactory;

    protected $table = 'rumah';

    protected $fillable = [
        'nomor_rumah',
        'status_rumah',
    ];

    public function riwayatPenghuni()
    {
        return $this->hasMany(RiwayatPenghuni::class, 'rumah_id');
    }

    public function pembayaranIuran()
    {
        return $this->hasMany(PembayaranIuran::class, 'rumah_id');
    }
}