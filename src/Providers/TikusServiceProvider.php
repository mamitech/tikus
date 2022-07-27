<?php

namespace Mamikos\Tikus\Providers;

use Mamikos\Tikus\Tikus;
use Illuminate\Support\ServiceProvider;
use Mamikos\Tikus\Console\PingCommand;

class TikusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('tikus', function () {
            return app()->make(Tikus::class);
        });        
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerArtisanCommands();
        }
    }

    protected function registerArtisanCommands(): void
    {
        $this->commands([
            PingCommand::class
        ]);
    }
}
