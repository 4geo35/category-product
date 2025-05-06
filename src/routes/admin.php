<?php

use Illuminate\Support\Facades\Route;
use GIS\CategoryProduct\Http\Controllers\Admin\CategoryController;
use GIS\CategoryProduct\Http\Controllers\Admin\ProductController;
use GIS\CategoryProduct\Http\Controllers\Admin\SpecificationController;
use GIS\CategoryProduct\Http\Controllers\Admin\SpecificationGroupController;

Route::middleware(["web", "auth", "app-management"])
    ->prefix("admin")
    ->as("admin.")
    ->group(function () {
        Route::prefix("categories")
            ->as("categories.")
            ->group(function () {
                $controllerClass = config("category-product.customAdminCategoryController") ?? CategoryController::class;
                Route::get("/", [$controllerClass, "index"])->name("index");
                Route::get("/{category}", [$controllerClass, "show"])->name("show");
            });

        Route::prefix("products")
            ->as("products.")
            ->group(function () {
                $controllerClass = config("category-product.customAdminProductController") ?? ProductController::class;
                Route::get("/", [$controllerClass, "index"])->name("index");
                Route::get("/{product}", [$controllerClass, "show"])->name("show");
            });

        Route::prefix("specification-groups")
            ->as("specification-groups.")
            ->group(function () {
                $groupControllerClass = config("category-product.customAdminSpecificationGroupController") ?? SpecificationGroupController::class;
                Route::get("/", [$groupControllerClass, "index"])->name("index");
            });

        Route::prefix("specifications")
            ->as("specifications.")
            ->group(function () {
                $specificationControllerClass = config("category-product.customAdminSpecificationController") ?? SpecificationController::class;
                Route::get("/", [$specificationControllerClass, "index"])->name("index");
            });
    });
