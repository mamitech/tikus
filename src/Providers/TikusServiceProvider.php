<?php

namespace Mamikos\Tikus\Providers;

use Mamikos\Tikus\Tikus;
use Illuminate\Support\ServiceProvider;

class TikusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('tikus', function () {
            return app()->make(Tikus::class);
        });        
    }
}
