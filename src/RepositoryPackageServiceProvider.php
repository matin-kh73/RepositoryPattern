<?php

namespace Mtkh\Repo;

use Illuminate\Support\ServiceProvider;
use Mtkh\Repo\Commands\FilterCommand;
use Mtkh\Repo\Commands\RepositoryCommand;

class RepositoryPackageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'repository');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()){
            $this->commands([
                RepositoryCommand::class,
                FilterCommand::class
            ]);
        }
        $this->publishes([__DIR__ .'/config/config.php' => config_path('repository.php')], 'repository');
    }
}
