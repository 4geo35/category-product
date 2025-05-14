<?php

namespace GIS\CategoryProduct\Models;

use GIS\CategoryProduct\Interfaces\SpecificationColorInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecificationColor extends Model implements SpecificationColorInterface
{
    protected $fillable = [
        "hash"
    ];

    public function value(): BelongsTo
    {
        $valueModelClass = config("category-product.customSpecificationValueModel") ?? SpecificationValue::class;
        return $this->belongsTo($valueModelClass, "value_id");
    }
}
