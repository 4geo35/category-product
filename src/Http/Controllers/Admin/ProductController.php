<?php

namespace GIS\CategoryProduct\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\CategoryProduct\Models\Category;
use GIS\CategoryProduct\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $productModelClass = config("category-product.customProductModel") ?? Product::class;
        Gate::authorize("viewAny", $productModelClass);
        return view("cp::admin.products.index");
    }

    public function show(ProductInterface $product): View
    {
        $productModelClass = config("category-product.customProductModel") ?? Product::class;
        Gate::authorize("viewAny", $productModelClass);
        return view("cp::admin.products.show", compact("product"));
    }
}
