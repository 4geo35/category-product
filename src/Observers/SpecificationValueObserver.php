<?php

namespace GIS\CategoryProduct\Observers;

use GIS\CategoryProduct\Facades\ProductActions;
use GIS\CategoryProduct\Interfaces\SpecificationValueInterface;

class SpecificationValueObserver
{
    public function creating(SpecificationValueInterface $value): void
    {
        $value->category_id = $value->product->category_id;
    }

    public function created(SpecificationValueInterface $value): void
    {
        $this->forgetValuesCache($value);
    }

    public function updated(SpecificationValueInterface $value): void
    {
        $this->forgetValuesCache($value);
    }

    public function deleted(SpecificationValueInterface $value): void
    {
        $this->forgetValuesCache($value);
        if ($value->color) { $value->color->delete(); }
    }

    protected function forgetValuesCache(SpecificationValueInterface $value): void
    {
        $category = $value->category;
        ProductActions::forgetSpecificationValues($category);
    }
}
