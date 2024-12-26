<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CertificateRepository;
use App\Repositories\CertificateRepositoryInterface;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Admin\AdminRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CertificateRepositoryInterface::class, CertificateRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
