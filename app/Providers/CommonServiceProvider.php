<?php

namespace App\Providers;

use App\services\ImageService;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ImageService::class, function ($app) {
            return new ImageService();
        });
    }
}
