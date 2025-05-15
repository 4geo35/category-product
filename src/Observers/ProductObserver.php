<?php

namespace GIS\CategoryProduct\Observers;

use GIS\CategoryProduct\Facades\CategoryActions;
use GIS\CategoryProduct\Facades\ProductActions;
use GIS\CategoryProduct\Interfaces\ProductInterface;

class ProductObserver
{
    public function created(ProductInterface $product): void
    {
        $this->forgetCategoryCache($product);
    }

    public function updated(ProductInterface $product): void
    {
        if (
            $product->wasChanged("category_id") &&
            ! $product->category->published_at
        ) {
            $product->published_at = null;
            $product->saveQuietly();
        }

        ProductActions::forgetTeaserData($product->id);
        if ($product->wasChanged("published_at")) {
            $this->forgetCategoryCache($product);
        }
    }

    public function deleted(ProductInterface $product): void
    {
        ProductActions::forgetTeaserData($product->id);
        $this->forgetCategoryCache($product);

        foreach ($product->specifications as $specification) {
            $specification->delete();
        }

        // TODO: check variations
    }

    protected function forgetCategoryCache(ProductInterface $product): void
    {
        $category = $product->category;
        ProductActions::forgetSpecificationValues($category);
        // TODO: forget pids
        // TODO: check variation
    }
}
