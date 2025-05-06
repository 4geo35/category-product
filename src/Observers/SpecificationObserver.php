<?php

namespace GIS\CategoryProduct\Observers;

use GIS\CategoryProduct\Interfaces\SpecificationInterface;
use GIS\CategoryProduct\Models\Specification;

class SpecificationObserver
{
    public function creating(SpecificationInterface $specification): void
    {
        $specificationModelClass = config("category-product.customSpecificationModel") ?? Specification::class;
        $priority = $specificationModelClass::query()
            ->select("id", "priority")
            ->max("priority");
        if (empty($priority)) { $priority = 0; }
        $specification->priority = $priority + 1;
    }

    public function created(SpecificationInterface $specification): void
    {
        // TODO: clear collection
    }

    public function updated(SpecificationInterface $specification): void
    {
        // TODO: clear collection
    }

    public function deleted(SpecificationInterface $specification): void
    {
        foreach ($specification->values as $value) {
            $value->delete();
        }
        // TODO: clear collection
    }
}
