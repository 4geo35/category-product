<?php

namespace GIS\CategoryProduct\Models;

use GIS\CategoryProduct\Interfaces\SpecificationValueInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpecificationValue extends Model implements SpecificationValueInterface
{
    protected $fillable = [
        "specification_id",
        "product_id",
        "category_id",
        "value",
    ];

    public function product(): BelongsTo
    {
        $productModelClass = config("category-product.customProductModel") ?? Product::class;
        return $this->belongsTo($productModelClass, "product_id");
    }

    public function category(): BelongsTo
    {
        $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
        return $this->belongsTo($categoryModelClass, "category_id");
    }

    public function specification(): BelongsTo
    {
        $specificationModel = config("category-product.customSpecificationModel") ?? Specification::class;
        return $this->belongsTo($specificationModel, "specification_id");
    }

    public function color(): HasOne
    {
        $colorModelClass = config("category-product.customSpecificationColorModel") ?? SpecificationColor::class;
        return $this->hasOne($colorModelClass, "value_id");
    }
}
