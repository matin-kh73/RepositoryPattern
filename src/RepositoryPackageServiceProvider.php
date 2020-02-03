<?php

namespace Mtkh\Repo;

use Illuminate\Support\ServiceProvider;
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
                RepositoryCommand::class
            ]);
        }
    }
}
