<?php

namespace GIS\CategoryProduct\Facades;

use GIS\CategoryProduct\Helpers\SpecificationActionsManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection getCollection()
 * @method static void clearCollection()
 * @method static array getSpecificationInfo(bool $filter = false)
 * @method static array formatCollection(Collection $collection)
 *
 * @see SpecificationActionsManager
 */
class SpecificationActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "specification-actions";
    }
}
