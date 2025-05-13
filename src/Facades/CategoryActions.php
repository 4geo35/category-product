<?php

namespace GIS\CategoryProduct\Facades;

use GIS\CategoryProduct\Helpers\CategoryActionsManager;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getParents(CategoryInterface $category)
 * @method static void forgetParents(CategoryInterface $category)
 *
 * @method static array getChildrenIds(CategoryInterface $category, bool $includeSelf = false)
 * @method static void forgetChildrenIds(CategoryInterface $category)
 *
 * @method static array getCategoryTree(array $newOrder = null)
 * @method static bool rebuildTree(array $newOrder)
 *
 * @method static void cascadeShutdown(CategoryInterface $category)
 *
 * @see CategoryActionsManager
 */
class CategoryActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "category-actions";
    }
}
