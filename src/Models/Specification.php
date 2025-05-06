<?php

namespace GIS\CategoryProduct\Models;

use GIS\CategoryProduct\Interfaces\SpecificationInterface;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function values(): HasMany
    {
        $valueModelClass = config("category-product.customSpecificationValueModel") ?? SpecificationValue::class;
        return $this->hasMany($valueModelClass, "specification_id");
    }

    public function products(): HasMany
    {
        return $this->values()
            ->select("id", "value", "specification_id", "product_id")
            ->with("product:id,title,slug");
    }
}
