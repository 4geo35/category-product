<?php

use Illuminate\Support\Facades\Route;
use GIS\CategoryProduct\Http\Controllers\Web\CatalogController;

Route::middleware(["web"])
    ->as("web.")
    ->group(function () {
        $catalogControllerClass = config("category-product.customWebCatalogController") ?? CatalogController::class;
        Route::get("/catalog", [$catalogControllerClass, "index"])->name("catalog");
        Route::get("/category", function () {
            return redirect()->route("web.catalog");
        });
        Route::get("/category/{category}", [$catalogControllerClass, "category"])->name("category");
        Route::get("/products", function () {
            return redirect()->route("web.catalog");
        });
        Route::get("/product/{product}", [$catalogControllerClass, "product"])->name("product");
    });
