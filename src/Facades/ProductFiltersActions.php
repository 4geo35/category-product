<?php

namespace GIS\CategoryProduct\Facades;

use GIS\CategoryProduct\Helpers\ProductFiltersActionsManager;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getFilters(CategoryInterface $category, bool $includeSubs = false)
 *
 * @see ProductFiltersActionsManager
 */
class ProductFiltersActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "product-filter-actions";
    }
}
