<?php

namespace Modules\Client;

use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
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

    protected function loadViewPage() :void
    {
        $this->loadViewsFrom(__DIR__.'/Views', "client");

    }

    protected function loadInterfaceRepository(): void
    {
    }

    protected function loadInterfaceService(): void
    {
    }
}
