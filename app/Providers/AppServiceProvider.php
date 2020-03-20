<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Image;
use App\Observers\ImageObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Image::observe(ImageObserver::class);
    }
}
