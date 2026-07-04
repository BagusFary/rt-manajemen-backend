<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\RumahRepository;
use App\Repositories\Eloquent\PenghuniRepository;
use App\Repositories\Eloquent\PengeluaranRepository;
use App\Repositories\Contracts\RumahRepositoryInterface;
use App\Repositories\Eloquent\PembayaranIuranRepository;
use App\Repositories\Eloquent\RiwayatPenghuniRepository;
use App\Repositories\Contracts\PenghuniRepositoryInterface;
use App\Repositories\Contracts\PengeluaranRepositoryInterface;
use App\Repositories\Contracts\PembayaranIuranRepositoryInterface;
use App\Repositories\Contracts\RiwayatPenghuniRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PenghuniRepositoryInterface::class, 
            PenghuniRepository::class
        );

        $this->app->bind(
            RumahRepositoryInterface::class, 
            RumahRepository::class
        );

        $this->app->bind(
            RiwayatPenghuniRepositoryInterface::class, 
            RiwayatPenghuniRepository::class
        );

        $this->app->bind(
            PembayaranIuranRepositoryInterface::class, 
            PembayaranIuranRepository::class
        );

        $this->app->bind(
            PengeluaranRepositoryInterface::class, 
            PengeluaranRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}