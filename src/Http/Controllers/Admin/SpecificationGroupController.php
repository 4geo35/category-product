<?php

namespace GIS\CategoryProduct\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SpecificationGroupController extends Controller
{
    public function index(): View
    {
        return view("cp::admin.specification-groups.index");
    }
}
