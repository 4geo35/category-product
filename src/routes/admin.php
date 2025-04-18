<?php

use Illuminate\Support\Facades\Route;
use GIS\CategoryProduct\Http\Controllers\Admin\CategoryController;

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
    });
