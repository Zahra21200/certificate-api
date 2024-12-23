<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CertificateRepository;
use App\Repositories\CertificateRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CertificateRepositoryInterface::class, CertificateRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
