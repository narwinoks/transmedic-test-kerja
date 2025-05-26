<?php

namespace Modules\Server;

use Illuminate\Support\ServiceProvider;
use Modules\Server\Repositories\User\UserInterface;
use Modules\Server\Repositories\User\UserRepository;
use Modules\Server\Services\Auth\AuthImplement;
use Modules\Server\Services\Auth\AuthService;

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
        $this->app->bind(
            UserInterface::class,
            UserRepository::class
        );
    }


    protected function loadInterfaceService(): void
    {
        $this->app->bind(
            AuthImplement::class,
            AuthService::class
        );
    }
}
