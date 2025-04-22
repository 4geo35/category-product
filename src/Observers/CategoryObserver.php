<?php

namespace GIS\CategoryProduct\Observers;

use GIS\CategoryProduct\Facades\CategoryActions;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Models\Category;

class CategoryObserver
{
    public function creating(CategoryInterface $category): void
    {
        $parentId = $category->parent_id;
        $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
        $priority = $categoryModelClass::query()
            ->select("id", "priority")
            ->where("parent_id", $parentId)
            ->max("priority");
        if (empty($priority)) { $priority = 0; }
        $category->priority = $priority + 1;
    }

    public function updated(CategoryInterface $category): void
    {
        if ($category->wasChanged("published_at")) {
            if (! $category->published_at) { CategoryActions::cascadeShutdown($category); }
        }

        if ($category->wasChanged("parent_id")) {
            $parent = $category->parent;
            if ($parent && ! $parent->published_at) {
                $category->published_at = null;
                $category->saveQuietly();
                CategoryActions::cascadeShutdown($category);
            }
        }
    }
}
