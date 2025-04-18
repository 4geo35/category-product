<?php

namespace GIS\CategoryProduct;

use Illuminate\Support\ServiceProvider;

class CategoryProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');

        // Config
        $this->mergeConfigFrom(__DIR__ . "/config/category-product.php", 'category-product');

        // Facades
        $this->initFacades();

        // Bindings
        $this->bindInterfaces();
    }

    public function boot(): void
    {
        // Views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'cp');

        // Livewire
        $this->addLivewireComponents();

        // Expand config
        $this->expandConfiguration();

        // Observers
        $this->observeModels();

        // Listeners
        $this->listenEvents();
    }

    protected function initFacades(): void
    {}

    protected function bindInterfaces(): void
    {}

    protected function addLivewireComponents(): void
    {}

    protected function expandConfiguration(): void
    {}

    protected function observeModels(): void
    {}

    protected function listenEvents(): void
    {}
}
