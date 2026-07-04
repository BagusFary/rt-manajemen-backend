<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran_iuran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumah_id')->constrained('rumah')->onDelete('cascade');
            $table->foreignId('penghuni_id')->constrained('penghuni')->onDelete('cascade');
            $table->enum('jenis_iuran', ['satpam', 'kebersihan']);
            $table->tinyInteger('bulan');
            $table->year('tahun');
            $table->bigInteger('jumlah_bayar');
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas']);
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_iuran');
    }
};
