<?php

namespace GIS\CategoryProduct;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Models\Category;
use GIS\CategoryProduct\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use GIS\CategoryProduct\Livewire\Admin\ListWire as CategoryListWire;

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
    {
        $categoryModelClass = config('category-product.customCategoryModel') ?? Category::class;
        $this->app->bind(CategoryInterface::class, $categoryModelClass);
    }

    protected function addLivewireComponents(): void
    {
        $component = config("category-product.customAdminCategoryListComponent");
        Livewire::component(
            "cp-admin-category-list",
            $component ?? CategoryListWire::class
        );
    }

    protected function expandConfiguration(): void
    {
        $cp = app()->config["category-product"];

        $um = app()->config["user-management"];
        $permissions = $um["permissions"];
        $permissions[] = [
            "title" => $cp["categoryPolicyTitle"],
            "key" => $cp["categoryPolicyKey"],
            "policy" => $cp["categoryPolicy"],
        ];
        app()->config["user-management.permissions"] = $permissions;
    }

    protected function observeModels(): void
    {
        $categoryModelClass = config('category-product.customCategoryModel') ?? Category::class;
        $categoryObserverClass = config("category-product.customCategoryModelObserver") ?? CategoryObserver::class;
        $categoryModelClass::observe($categoryObserverClass);
    }

    protected function listenEvents(): void
    {}
}
