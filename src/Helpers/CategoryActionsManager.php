<?php

namespace GIS\CategoryProduct\Helpers;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Models\Category;
use GIS\TraitsHelpers\Interfaces\ShouldTreeInterface;
use GIS\TraitsHelpers\Traits\ManagerTreeTrait;

class CategoryActionsManager
{
    use ManagerTreeTrait;

    public function __construct()
    {
        $this->modelClass = config("category-product.customCategoryModel") ?? Category::class;
        $this->hasImage = true;
    }

    public function cascadeShutdown(CategoryInterface $category): void
    {
        foreach ($category->children as $child) {
            if (! $child->published_at) { continue; }
            $child->update([
                "published_at" => null,
            ]);
        }
        // TODO: does need make a queue?
        // TODO: disable products
    }

    protected function expandItemData(&$data, ShouldTreeInterface $category): void
    {
        $data["published_at"] = $category->published_at ?? null;
    }
}
