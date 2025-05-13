<?php

namespace GIS\CategoryProduct\Facades;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection getSpecifications(ProductInterface $product)
 * @method static array getSpecificationsByGroup(ProductInterface $product)
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
