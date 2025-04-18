<?php

namespace GIS\CategoryProduct\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
        Gate::authorize("viewAny", $categoryModelClass);
        return view("cp::admin.categories.index");
    }

    public function show(CategoryInterface $category): View
    {
        $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
        Gate::authorize("viewAny", $categoryModelClass);
        return view("cp::admin.categories.show", compact("category"));
    }
}
