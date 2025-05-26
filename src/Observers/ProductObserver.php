<?php

namespace GIS\CategoryProduct\Observers;

use GIS\CategoryProduct\Facades\CategoryActions;
use GIS\CategoryProduct\Facades\ProductActions;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\ProductVariation\Facades\ProductVariationActions;

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

        if (config("product-variation")) {
            foreach ($product->variations as $variation) {
                $variation->delete();
            }
            // TODO: delete from order items
        }
    }

    protected function forgetCategoryCache(ProductInterface $product): void
    {
        $category = $product->category;
        ProductActions::forgetSpecificationValues($category);
        CategoryActions::forgetProductIds($category);
        if (config("product-variation")) {
            ProductVariationActions::forgetPricesForCategory($category);
        }
    }
}
