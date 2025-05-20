<?php

namespace GIS\CategoryProduct\Models;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\Fileable\Traits\ShouldGallery;
use GIS\Metable\Traits\ShouldMeta;
use GIS\ProductVariation\Models\ProductVariation;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use GIS\TraitsHelpers\Traits\ShouldHumanPublishDate;
use GIS\TraitsHelpers\Traits\ShouldMarkdown;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model implements ProductInterface
{
    use ShouldSlug, ShouldGallery, ShouldMeta, ShouldHumanDate, ShouldHumanPublishDate, ShouldMarkdown;

    protected $fillable = [
        "title",
        "slug",
        "short",
        "description",
        "published_at",
    ];

    public function category(): BelongsTo
    {
        $categoryClass = config("category-product.customCategoryModel") ?? Category::class;
        return $this->belongsTo($categoryClass, "category_id");
    }

    public function specifications(): HasMany
    {
        $valueModelClass = config("category-product.customSpecificationValueModel") ?? SpecificationValue::class;
        return $this->hasMany($valueModelClass, "product_id");
    }

    public function variations(): HasMany
    {
        if (config("product-variation")) {
            $variationModelClass = config("product-variation.customVariationModel") ?? ProductVariation::class;
            return $this->hasMany($variationModelClass, "product_id");
        } else {
            return new HasMany($this->newQuery(), $this, "", "");
        }
    }

    // TODO: order items
}
