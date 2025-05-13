<?php

namespace GIS\CategoryProduct\Helpers;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\CategoryProduct\Interfaces\SpecificationGroupInterface;
use GIS\CategoryProduct\Interfaces\SpecificationInterface;
use GIS\CategoryProduct\Interfaces\SpecificationValueInterface;
use GIS\CategoryProduct\Models\SpecificationGroup;
use Illuminate\Database\Eloquent\Collection;

class ProductActionsManager
{
    public function getSpecifications(ProductInterface $product): Collection
    {
        return $product->specifications()
            ->join(
                "specifications",
                "specification_values.specification_id",
                "=",
                "specifications.id"
            )
            ->with(
                "specification:id,title,group_id,priority",
                "specification.group:id,title"
            )
            ->select(
                "specification_values.id",
                "specification_values.specification_id",
                "specification_values.value",

                "specifications.id as spec_id",
                "specifications.title",
                "specifications.priority",
                "specifications.group_id",
                "specifications.type"
            )
            ->orderBy("specifications.priority")
            ->orderBy("value")
            ->get();
    }

    public function getSpecificationsByGroup(ProductInterface $product): array
    {
        $specifications = $this->getSpecifications($product);
        $noGroup = [];
        $groups = [];
        foreach ($specifications as $item) {
            /**
             * @var SpecificationValueInterface $item
             */
            $specification = $item->specification;
            /**
             * @var SpecificationInterface $specification
             */
            $group = $specification->group;
            /**
             * @var SpecificationGroupInterface $group
             */
            $id = $specification->id;
            if (empty($group)) {
                if (empty($noGroup[$id])) {
                    $noGroup[$id] = (object) [
                        "values" => [],
                        "title" => $item->title,
                    ];
                }
                $noGroup[$id]->values[] = $item->value;
            } else {
                $groupId = $group->id;
                if (empty($groups[$groupId])) {
                    $groups[$groupId] = [
                        "title" => $group->title,
                        "items" => [],
                    ];
                }
                if (empty($groups[$groupId]["items"][$id])) {
                    $groups[$groupId]["items"][$id] = (object) [
                        "values" => [],
                        "title" => $item->title,
                    ];
                }
                $groups[$groupId]["items"][$id]->values[] = $item->value;
            }
        }

        $array = [];
        if (! empty($groups)) {
            $groupIds = array_keys($groups);
            $groupModelClass = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
            $collectionOfIds = $groupModelClass::query()
                ->select("id")
                ->whereIn("id", $groupIds)
                ->orderBy("priority")
                ->get();
            foreach ($collectionOfIds as $item) {
                $array[] = (object) $groups[$item->id];
            }
        }

        return [
            "noGroup" => $noGroup,
            "groups" => $array,
        ];
    }
}
