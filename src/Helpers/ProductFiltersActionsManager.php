<?php

namespace GIS\CategoryProduct\Helpers;

use GIS\CategoryProduct\Facades\ProductActions;
use GIS\CategoryProduct\Facades\SpecificationActions;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Traits\FilterQuery;
use GIS\CategoryProduct\Traits\FilterView;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductFiltersActionsManager
{
    use FilterView, FilterQuery;

    protected CategoryInterface|null $category = null;
    protected Request|null $request = null;
    protected Builder|null $query = null;
    protected array $categoryIds = [];
    protected array $slugValues = [];

    public function getFilters(CategoryInterface $category, bool $includeSubs = false): array
    {
        $this->category = $category;
        $this->request = request();
        $specInfo = SpecificationActions::getSpecificationInfo(true);
        $specValues = ProductActions::getSpecificationValues($category);
        // Распределение полученных значений
        $this->setProductValuesToFilter($specInfo, $specValues);
        // TODO: setPriceFilter
        $this->prepareRangeFilters($specInfo);
        $this->prepareCheckboxFilters($specInfo);
        $this->prepareColorFilters($specInfo);
        return array_values(Arr::sort($specInfo, function (object $value) {
            return $value->priority;
        }));
    }
}
