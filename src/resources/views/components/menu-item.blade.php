@php
    $categoryActive = in_array(Route::currentRouteName(), [
        "admin.categories.index", "admin.categories.show"
    ]);
    $productActive = in_array(Route::currentRouteName(), [
        "admin.products.index", "admin.products.show"
    ]);
    $specificationActive = in_array(Route::currentRouteName(), [
        "admin.specifications.index"
    ]);
    $specificationGroupActive = in_array(Route::currentRouteName(), [
       "admin.specification-groups.index"
    ]);
@endphp

@can("viewAny", config("category-product.customCategoryModel") ?? \GIS\CategoryProduct\Models\Category::class)
    <x-tt::admin-menu.item href="{{ route('admin.categories.index') }}"
                           :active="$categoryActive">
        <x-slot name="ico"><x-cp::ico.tree /></x-slot>
        Категории товаров
    </x-tt::admin-menu.item>
@endcan

@can("viewAny", config("category-product.customProductModel") ?? \GIS\CategoryProduct\Models\Product::class)
    <x-tt::admin-menu.item href="{{ route('admin.products.index') }}"
                            :active="$productActive">
        <x-slot name="ico"><x-cp::ico.inventory /></x-slot>
        Товары
    </x-tt::admin-menu.item>
@endcan
