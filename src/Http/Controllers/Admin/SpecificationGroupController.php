<?php

namespace GIS\CategoryProduct\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\CategoryProduct\Models\SpecificationGroup;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SpecificationGroupController extends Controller
{
    public function index(): View
    {
        $groupModelClass = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
        Gate::authorize("viewAny", $groupModelClass);
        return view("cp::admin.specification-groups.index");
    }
}
