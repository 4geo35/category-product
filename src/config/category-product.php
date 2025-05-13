<?php

return [
    // Settings
    "specificationTypes" => [
        "checkbox" => "Checkbox",
        "select" => "Select",
        "color" => "Цвет",
    ],

    // Web
    "customWebCatalogController" => null,
    "useBreadcrumbs" => true,
    "useH1" => true,
    "catalogPageTitle" => "Каталог",

    // Sort
    "defaultSort" => "title",
    "defaultSortDirection" => "asc",
    "categoryProductsPerPage" => 18,
    "sortOptions" => [
        "title.asc" => (object) [
            "title" => "По названию",
            "by" => "title",
            "direction" => "asc",
            "ico" => "cp::web.catalog.sort.alpha-down"
        ],
        "title.desc" => (object) [
            "title" => "По названию",
            "by" => "title",
            "direction" => "desc",
            "ico" => "cp::web.catalog.sort.alpha-up"
        ],
        "published_at.desc" => (object) [
            "title" => "Сначала новые",
            "by" => "published_at",
            "direction" => "desc",
            "ico" => "cp::web.catalog.sort.publish-down"
        ],
        "published_at.asc" => (object) [
            "title" => "Сначала старые",
            "by" => "published_at",
            "direction" => "asc",
            "ico" => "cp::web.catalog.sort.publish-up"
        ],
    ],

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
    "customProductActionsManager" => null,
    "customProductFilterActionsManager" => null,
    "customSpecificationActionsManager" => null,

    // Components
    "customAdminCategoryListComponent" => null,
    "customAdminCategoryShowComponent" => null,

    "customAdminProductListComponent" => null,
    "customAdminProductShowComponent" => null,

    "customAdminSpecificationGroupIndexComponent" => null,

    "customAdminSpecificationIndexComponent" => null,

    "customAdminSpecificationValueListComponent" => null,

    "customWebProductListComponent" => null,
    "customWebCategoryFilterComponent" => null,

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
