<?php

namespace GIS\CategoryProduct\Traits;

use Illuminate\Support\Arr;

trait FilterView
{
    protected function setProductValuesToFilter(array &$specInfo, array $specValues): void
    {
        // Записать значения.
        foreach ($specInfo as &$spec) {
            if (! isset($spec->values)) $spec->values = [];
            $specId = $spec->id;
            if (empty($specValues[$specId])) continue;
            $spec->values = Arr::sort($specValues[$specId]);
        }

        // Убрать пустые.
        foreach ($specInfo as $key => $item) {
            if (empty($item->values)) unset($specInfo[$key]);
        }
    }

    protected function prepareRangeFilters(&$specInfo): void
    {
        foreach ($specInfo as $key => &$filter) {
            if ($filter->type !== "range") continue;
            $filter->render = $this->checkCanRangeRender($filter);
            if ($filter->render) {
                $filter->min = min($filter->values);
                $filter->max = max($filter->values);
            } else {
                unset($specInfo[$key]);
            }
        }
    }

    protected function checkCanRangeRender($filter): bool
    {
        if (empty($filter->values)) return false;
        if (count($filter->values) <= 1) return false;

        foreach ($filter->values as $value) {
            if (! is_numeric($value)) return false;
        }
        return true;
    }

    protected function prepareCheckboxFilters(&$specInfo): void
    {
        foreach ($specInfo as $key => &$filter) {
            if ($filter->type !== "checkbox") continue;
            $current = $this->request->get("check-{$filter->slug}", []);
            $renderValues = [];
            $i = 0;
            foreach ($filter->values as $id => $value) {
                $i++;
                $renderValues[] = [
                    "id" => $id,
                    "value" => $value,
                    "checked" => in_array($value, $current),
                    "inputName" => "check-{$filter->slug}[]",
                    "inputId" => "{$id}-{$filter->slug}-{$i}",
                ];
            }
            $filter->renderValues = $renderValues;
        }
    }
}
