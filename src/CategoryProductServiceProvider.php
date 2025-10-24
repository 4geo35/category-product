<?php

namespace GIS\CategoryProduct;

use GIS\CategoryProduct\Helpers\CategoryActionsManager;
use GIS\CategoryProduct\Helpers\ProductActionsManager;
use GIS\CategoryProduct\Helpers\ProductFiltersActionsManager;
use GIS\CategoryProduct\Helpers\SpecificationActionsManager;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\CategoryProduct\Livewire\Web\Catalog\CheckboxFilterWire;
use GIS\CategoryProduct\Livewire\Web\Catalog\ColorFilterWire;
use GIS\CategoryProduct\Livewire\Web\Catalog\SetProductViewCookie;
use GIS\CategoryProduct\Models\Category;
use GIS\CategoryProduct\Models\Product;
use GIS\CategoryProduct\Models\Specification;
use GIS\CategoryProduct\Models\SpecificationGroup;
use GIS\CategoryProduct\Models\SpecificationValue;
use GIS\CategoryProduct\Observers\CategoryObserver;
use GIS\CategoryProduct\Observers\ProductObserver;
use GIS\CategoryProduct\Observers\SpecificationGroupObserver;
use GIS\CategoryProduct\Observers\SpecificationObserver;
use GIS\CategoryProduct\Observers\SpecificationValueObserver;
use GIS\Fileable\Traits\ExpandTemplatesTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use GIS\CategoryProduct\Livewire\Admin\Categories\ListWire as AdminCategoryListWire;
use GIS\CategoryProduct\Livewire\Admin\Categories\ShowWire as AdminCategoryShowWire;
use GIS\CategoryProduct\Livewire\Admin\Products\ListWire as AdminProductListWire;
use GIS\CategoryProduct\Livewire\Admin\Products\ShowWire as AdminProductShowWire;
use GIS\CategoryProduct\Livewire\Admin\SpecificationGroups\IndexWire as AdminGroupIndexWire;
use GIS\CategoryProduct\Livewire\Admin\Specifications\IndexWire as AdminSpecificationIndexWire;
use GIS\CategoryProduct\Livewire\Admin\SpecificationValues\ListWire as AdminSpecificationValueListWire;
use GIS\CategoryProduct\Livewire\Web\Catalog\ProductListWire;
use GIS\CategoryProduct\Livewire\Web\Catalog\CategoryFilterWire;

class CategoryProductServiceProvider extends ServiceProvider
{
    use ExpandTemplatesTrait;

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

        // Policies
        $this->setPolicies();

        // Listeners
        $this->listenEvents();
    }

    protected function setPolicies(): void
    {
        Gate::policy(config("category-product.customProductModel") ?? Product::class, config("category-product.productPolicy"));
        Gate::policy(config("category-product.customCategoryModel") ?? Category::class, config("category-product.categoryPolicy"));
        Gate::policy(config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class, config("category-product.specificationGroupPolicy"));
        Gate::policy(config("category-product.customSpecificationModel") ?? Specification::class, config("category-product.specificationPolicy"));
    }

    protected function initFacades(): void
    {
        $this->app->singleton("category-actions", function () {
            $categoryActionsManagerClass = config("category-product.customCategoryActionsManager") ?? CategoryActionsManager::class;
            return new $categoryActionsManagerClass;
        });

        $this->app->singleton("product-actions", function () {
            $productActionsManagerClass = config("category-product.customProductActionsManager") ?? ProductActionsManager::class;
            return new $productActionsManagerClass;
        });

        $this->app->singleton("product-filter-actions", function () {
            $filterActionsManagerClass = config("category-product.customProductFilterActionsManager") ?? ProductFiltersActionsManager::class;
            return new $filterActionsManagerClass;
        });

        $this->app->singleton("specification-actions", function () {
            $specificationActionsManagerClass = config("category-product.customSpecificationActionsManager") ?? SpecificationActionsManager::class;
            return new $specificationActionsManagerClass;
        });
    }

    protected function bindInterfaces(): void
    {
        $categoryModelClass = config('category-product.customCategoryModel') ?? Category::class;
        $this->app->bind(CategoryInterface::class, $categoryModelClass);

        $productModelClass = config('category-product.customProductModel') ?? Product::class;
        $this->app->bind(ProductInterface::class, $productModelClass);
    }

    protected function addLivewireComponents(): void
    {
        $component = config("category-product.customAdminCategoryListComponent");
        Livewire::component(
            "cp-admin-category-list",
            $component ?? AdminCategoryListWire::class
        );

        $component = config("category-product.customAdminCategoryShowComponent");
        Livewire::component(
            "cp-admin-category-show",
            $component ?? AdminCategoryShowWire::class
        );

        $component = config("category-product.customAdminProductListComponent");
        Livewire::component(
            "cp-admin-product-list",
            $component ?? AdminProductListWire::class
        );

        $component = config("category-product.customAdminProductShowComponent");
        Livewire::component(
            "cp-admin-product-show",
            $component ?? AdminProductShowWire::class
        );

        $component = config("category-product.customAdminSpecificationGroupIndexComponent");
        Livewire::component(
            "cp-admin-specification-group-index",
            $component ?? AdminGroupIndexWire::class
        );

        $component = config("category-product.customAdminSpecificationIndexComponent");
        Livewire::component(
            "cp-admin-specification-index",
            $component ?? AdminSpecificationIndexWire::class
        );

        $component = config("category-product.customAdminSpecificationValueListComponent");
        Livewire::component(
            "cp-admin-specification-value-list",
            $component ?? AdminSpecificationValueListWire::class
        );

        $component = config("category-product.customWebProductListComponent");
        Livewire::component(
            "cp-product-list",
            $component ?? ProductListWire::class
        );

        $component = config("category-product.customWebProductCookieComponent");
        Livewire::component(
            "cp-product-view-cookie",
            $component ?? SetProductViewCookie::class
        );

        $component = config("category-product.customWebCategoryFilterComponent");
        Livewire::component(
            "cp-category-filter",
            $component ?? CategoryFilterWire::class
        );

        $component = config("category-product.customWebCheckboxFilterComponent");
        Livewire::component(
            "cp-checkbox-filter",
            $component ?? CheckboxFilterWire::class
        );

        $component = config("category-product.customWebColorFilterComponent");
        Livewire::component(
            "cp-color-filter",
            $component ?? ColorFilterWire::class
        );
    }

    protected function expandConfiguration(): void
    {
        $cp = app()->config["category-product"];
        $this->expandTemplates($cp);

        $um = app()->config["user-management"];
        $permissions = $um["permissions"];
        $permissions[] = [
            "title" => $cp["categoryPolicyTitle"],
            "key" => $cp["categoryPolicyKey"],
            "policy" => $cp["categoryPolicy"],
        ];
        $permissions[] = [
            "title" => $cp["productPolicyTitle"],
            "key" => $cp["productPolicyKey"],
            "policy" => $cp["productPolicy"],
        ];
        $permissions[] = [
            "title" => $cp["specificationPolicyTitle"],
            "key" => $cp["specificationPolicyKey"],
            "policy" => $cp["specificationPolicy"],
        ];
        $permissions[] = [
            "title" => $cp["specificationGroupPolicyTitle"],
            "key" => $cp["specificationGroupPolicyKey"],
            "policy" => $cp["specificationGroupPolicy"],
        ];
        app()->config["user-management.permissions"] = $permissions;
    }

    protected function observeModels(): void
    {
        $categoryModelClass = config('category-product.customCategoryModel') ?? Category::class;
        $categoryObserverClass = config("category-product.customCategoryModelObserver") ?? CategoryObserver::class;
        $categoryModelClass::observe($categoryObserverClass);

        $productModelClass = config("category-product.customProductModel") ?? Product::class;
        $productObserverClass = config("category-product.customProductModelObserver") ?? ProductObserver::class;
        $productModelClass::observe($productObserverClass);

        $groupModelClass = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
        $groupObserverClass = config("category-product.customSpecificationGroupModelObserver") ?? SpecificationGroupObserver::class;
        $groupModelClass::observe($groupObserverClass);

        $specificationModelClass = config("category-product.customSpecificationModel") ?? Specification::class;
        $specificationObserverClass = config("category-product.customSpecificationModelObserver") ?? SpecificationObserver::class;
        $specificationModelClass::observe($specificationObserverClass);

        $valueModelClass = config("category-product.customSpecificationValueModel") ?? SpecificationValue::class;
        $valueObserverClass = config("category-product.customSpecificationValueModelObserver") ?? SpecificationValueObserver::class;
        $valueModelClass::observe($valueObserverClass);
    }

    protected function listenEvents(): void
    {}
}
