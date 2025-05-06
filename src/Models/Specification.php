<?php

namespace GIS\CategoryProduct\Models;

use GIS\CategoryProduct\Interfaces\SpecificationInterface;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Specification extends Model implements SpecificationInterface
{
    use ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
        "type",
        "group_id",
        "in_filter",
    ];

    public function group(): BelongsTo
    {
        $groupModel = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
        return $this->belongsTo($groupModel, "group_id");
    }

    // TODO: add values

    // TODO: add products
}
