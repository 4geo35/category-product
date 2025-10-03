<?php

namespace GIS\CategoryProduct\Facades;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getGridView()
 * @method static void setGridView(string $view)
 *
 * @method static ProductInterface|null getTeaserData(int $id)
 * @method static void forgetTeaserData(int $id)
 *
 * @method static array getSpecificationList(ProductInterface $product)
 *
 * @method static Collection getSpecifications(ProductInterface $product)
 * @method static array getSpecificationsByGroup(ProductInterface $product)
 *
 * @method static array getSpecificationValues(CategoryInterface $category)
 * @method static void forgetSpecificationValues(CategoryInterface $category)
 *
 * @see ProductActionsManager
 */
class ProductActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "product-actions";
    }
}
