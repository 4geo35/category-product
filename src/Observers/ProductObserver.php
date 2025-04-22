<?php

namespace GIS\CategoryProduct\Observers;

use GIS\CategoryProduct\Interfaces\ProductInterface;

class ProductObserver
{
    public function created(ProductInterface $product): void
    {
        // TODO: forget category cache
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

        // TODO: forget teaser data
        if ($product->wasChanged("published_at")) {
            // TODO: forget category cache
        }
    }

    public function deleted(ProductInterface $product): void
    {
        // TODO: forget teaser data
        // TODO: clear specifications
    }
}
