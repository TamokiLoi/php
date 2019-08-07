<?php

namespace App\ImageStore\Providers;

use Illuminate\Support\ServiceProvider;
use App\ImageStore\ToolFactory;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ToolFactory::class, function () {
            return new ToolFactory();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
     
    }
}
