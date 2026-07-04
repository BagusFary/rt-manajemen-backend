<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\PenghuniRepositoryInterface;
use App\Repositories\Eloquent\PenghuniRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PenghuniRepositoryInterface::class, 
            PenghuniRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}