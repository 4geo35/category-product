<?php

namespace GIS\CategoryProduct\Observers;

use GIS\CategoryProduct\Interfaces\SpecificationGroupInterface;
use GIS\CategoryProduct\Models\SpecificationGroup;

class SpecificationGroupObserver
{
    public function creating(SpecificationGroupInterface $group): void
    {
        $groupModelClass = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
        $priority = $groupModelClass::query()
            ->select("id", "priority")
            ->max("priority");
        if (empty($priority)) { $priority = 0; }
        $group->priority = $priority + 1;
    }

    public function deleted(SpecificationGroupInterface $group): void
    {
        // TODO: disassociate specifications
    }
}
