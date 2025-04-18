<?php

namespace GIS\CategoryProduct\Models;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\Fileable\Traits\ShouldImage;
use GIS\Metable\Traits\ShouldMeta;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use GIS\TraitsHelpers\Traits\ShouldHumanPublishDate;
use GIS\TraitsHelpers\Traits\ShouldMarkdown;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use GIS\TraitsHelpers\Traits\ShouldTree;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements CategoryInterface
{
    use ShouldSlug, ShouldImage, ShouldMeta, ShouldMarkdown, ShouldTree, ShouldHumanDate, ShouldHumanPublishDate;

    protected $fillable = [
        "title",
        "slug",
        "description",
        "short",
        "priority",
        "published_at",
    ];
}
