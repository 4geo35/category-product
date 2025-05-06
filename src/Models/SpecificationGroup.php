<?php

namespace GIS\CategoryProduct\Models;

use GIS\CategoryProduct\Interfaces\SpecificationGroupInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecificationGroup extends Model implements SpecificationGroupInterface
{
    protected $fillable = [
        "title",
    ];

    public function specifications(): HasMany
    {
        $specificationModel = config("category-product.customSpecificationModel") ?? Specification::class;
        return $this->hasMany($specificationModel, "group_id");
    }
}
