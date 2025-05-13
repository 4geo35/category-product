<?php

namespace GIS\CategoryProduct\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GIS\CategoryProduct\Facades\CategoryActions;
use GIS\CategoryProduct\Facades\ProductActions;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\CategoryProduct\Models\Category;
use GIS\Metable\Facades\MetaActions;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
        $categories = $categoryModelClass::query()
            ->with("image")
            ->whereNull("parent_id")
            ->orderBy("priority")
            ->get();
        return view("cp::web.catalog.index", compact("categories"));
    }

    public function category(CategoryInterface $category): View
    {
        $parents = CategoryActions::getParents($category);
        $children = $category->children()
            ->orderBy("priority")
            ->get();
        $metas = MetaActions::renderByModel($category);
        return view(
            "cp::web.catalog.category",
            compact("parents", "children", "metas", "category")
        );
    }

    public function product(ProductInterface $product): View
    {
        $product->load("images", "category");
        $parents = CategoryActions::getParents($product->category);
        $metas = MetaActions::renderByModel($product);
        $images = $product->images()->orderBy("priority")->get();
        $specificationData = ProductActions::getSpecificationsByGroup($product);
        return view(
            "cp::web.catalog.product",
            compact("product", "parents", "metas", "images", "specificationData")
        );
    }
}
