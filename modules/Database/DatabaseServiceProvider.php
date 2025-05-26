<?php

namespace Modules\Database;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint as BaseBlueprint;
use Modules\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->loadInterfaceRepository();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesAuth();
        $this->loadInterfaceService();
        $this->loadViewPage();
        $this->loadData();
        Builder::macro('blueprint', function () {
            return new Blueprint($this);
        });
    }

    protected function loadRoutesAuth(): void
    {
        $this->app->bind(BaseBlueprint::class, Blueprint::class);
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    protected function loadViewPage() :void
    {

    }
    protected function loadData() :void
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    protected function loadInterfaceRepository(): void
    {
    }

    protected function loadInterfaceService(): void
    {
    }

}
