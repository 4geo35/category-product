<?php

namespace GIS\CategoryProduct\Observers;

use GIS\CategoryProduct\Facades\CategoryActions;
use GIS\CategoryProduct\Facades\ProductActions;
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

            CategoryActions::forgetParents($category);
            ProductActions::forgetSpecificationValues($category);
            CategoryActions::forgetParents($category);
            if ($parent) {
                CategoryActions::forgetChildrenIds($parent);
            }
            // TODO: forget prices

            if ($parent && ! $parent->published_at) {
                $category->published_at = null;
                $category->saveQuietly();
                CategoryActions::cascadeShutdown($category);
            }

            $oldParent = $category->getOriginal("parent_id");
            if (! empty($oldParent)) {
                $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
                $oldCategory = $categoryModelClass::find($oldParent);
                if (! empty($oldCategory)) {
                    ProductActions::forgetSpecificationValues($oldCategory);
                    CategoryActions::forgetChildrenIds($oldCategory);
                    // TODO: forget prices
                }
            }
        }
    }

    public function deleted(CategoryInterface $category): void
    {
        CategoryActions::forgetParents($category);
        ProductActions::forgetSpecificationValues($category);
        // TODO: forget prices
    }
}
