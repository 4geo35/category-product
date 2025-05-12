<?php

namespace GIS\CategoryProduct\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\CategoryProduct\Models\Specification;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SpecificationController extends Controller
{
    public function index(): View
    {
        $specificationModelClass = config("category-product.customSpecificationModel") ?? Specification::class;
        Gate::authorize("viewAny", $specificationModelClass);
        return view("cp::admin.specifications.index");
    }
}
