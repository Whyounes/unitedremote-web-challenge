<?php

namespace App\Providers;

use App\Repositories\EloquentShopRepository;
use App\Repositories\EloquentUserRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositoriesBinding();
    }

    protected function registerRepositoriesBinding()
    {
        $this->app->bind(ShopRepository::class, EloquentShopRepository::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
    }
}
