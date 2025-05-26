<?php

namespace Modules\Database;

use Illuminate\Support\ServiceProvider;

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
    }

    protected function loadRoutesAuth(): void
    {
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
