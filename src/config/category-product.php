<?php

return [
    // Admin
    "customCategoryModel" => null,
    "customCategoryModelObserver" => null,

    "customAdminCategoryController" => null,

    // Facades
    "customCategoryActionsManager" => null,

    // Components
    "customAdminCategoryListComponent" => null,
    "customAdminCategoryShowComponent" => null,

    // Policy
    "categoryPolicyTitle" => "Управление категориями товаров",
    "categoryPolicy" => \GIS\CategoryProduct\Policies\CategoryPolicy::class,
    "categoryPolicyKey" => "categories",
];
