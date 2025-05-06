<?php

namespace GIS\CategoryProduct\Observers;

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
    }

    protected function forgetValuesCache(SpecificationValueInterface $value): void
    {
        $category = $value->category;
        // TODO: forget cache
    }
}
