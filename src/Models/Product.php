<?php

namespace GIS\CategoryProduct\Models;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\Fileable\Traits\ShouldGallery;
use GIS\Metable\Traits\ShouldMeta;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use GIS\TraitsHelpers\Traits\ShouldHumanPublishDate;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model implements ProductInterface
{
    use ShouldSlug, ShouldGallery, ShouldMeta, ShouldHumanDate, ShouldHumanPublishDate;

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
}
