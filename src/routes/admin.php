<?php

use Illuminate\Support\Facades\Route;
use GIS\CategoryProduct\Http\Controllers\Admin\CategoryController;
use GIS\CategoryProduct\Http\Controllers\Admin\ProductController;

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
    });
