<?php

namespace Modules\Server;

use Illuminate\Support\ServiceProvider;

class ServerServiceProvider extends ServiceProvider
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
    }

    protected function loadRoutesAuth(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    protected function loadViewPage()
    {
        $this->loadViewsFrom(__DIR__.'/Views', "Server");

    }

    protected function loadInterfaceRepository(): void
    {
    }

    protected function loadInterfaceService(): void
    {
    }
}
