<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\PenghuniRepositoryInterface;
use App\Repositories\Eloquent\PenghuniRepository;
use App\Repositories\Contracts\RumahRepositoryInterface;
use App\Repositories\Eloquent\RumahRepository;
use App\Repositories\Contracts\RiwayatPenghuniRepositoryInterface;
use App\Repositories\Eloquent\RiwayatPenghuniRepository;

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
    }

    public function boot(): void
    {
        //
    }
}