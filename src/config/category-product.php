<?php

return [
    // Admin
    "customCategoryModel" => null,
    "customCategoryModelObserver" => null,

    "customProductModel" => null,
    "customProductModelObserver" => null,

    "customSpecificationGroupModel" => null,
    "customSpecificationGroupModelObserver" => null,

    "customSpecificationModel" => null,
    "customSpecificationModelObserver" => null,

    "customSpecificationValueModel" => null,
    "customSpecificationValueModelObserver" => null,

    "customAdminCategoryController" => null,
    "customAdminProductController" => null,
    "customAdminSpecificationController" => null,
    "customAdminSpecificationGroupController" => null,

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

    "specificationPolicyTitle" => "Управление характеристиками",
    "specificationPolicy" => \GIS\CategoryProduct\Policies\SpecificationPolicy::class,
    "specificationPolicyKey" => "specifications",

    "specificationGroupPolicyTitle" => "Управление группами характеристик",
    "specificationGroupPolicy" => \GIS\CategoryProduct\Policies\SpecificationGroupPolicy::class,
    "specificationGroupPolicyKey" => "specification_groups",
];
