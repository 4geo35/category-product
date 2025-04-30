<?php

return [
    // Admin
    "customCategoryModel" => null,
    "customCategoryModelObserver" => null,

    "customProductModel" => null,
    "customProductModelObserver" => null,

    "customAdminCategoryController" => null,

    // Facades
    "customCategoryActionsManager" => null,

    // Components
    "customAdminCategoryListComponent" => null,
    "customAdminCategoryShowComponent" => null,

    "customAdminProductListComponent" => null,
    "customAdminProductShowComponent" => null,

    // Policy
    "categoryPolicyTitle" => "Управление категориями товаров",
    "categoryPolicy" => \GIS\CategoryProduct\Policies\CategoryPolicy::class,
    "categoryPolicyKey" => "categories",

    "productPolicyTitle" => "Управление товарами",
    "productPolicy" => \GIS\CategoryProduct\Policies\ProductPolicy::class,
    "productPolicyKey" => "products",
];
