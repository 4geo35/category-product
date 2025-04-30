<?php

namespace GIS\CategoryProduct\Livewire\Admin\Products;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\CategoryProduct\Models\Category;
use GIS\CategoryProduct\Traits\ProductEditActions;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ShowWire extends Component
{
    use ProductEditActions;

    public ProductInterface $product;
    public bool $displayCategory = false;
    public Collection|null $categoryList = null;
    public string $searchCategory = '';
    public CategoryInterface|null $chosenCategory = null;

    public function updated($property, $value): void
    {
        if ($property === 'searchCategory') { $this->setCategoryList(); }
    }

    public function render(): View
    {
        return view("cp::livewire.admin.products.show-wire");
    }

    public function showCategory(): void
    {
        if (! $this->checkAuth("update", $this->product)) { return; }
        $this->displayCategory = true;
        $this->reset("categoryList", "searchCategory", "chosenCategory");
        $this->setCategoryList();
    }

    public function chooseCategory(int $id): void
    {
        $category = $this->findCategory($id);
        if (! $category) { return; }
        $this->chosenCategory = $category;
    }

    public function cancelChose(): void
    {
        $this->reset("chosenCategory");
    }

    public function confirmChose(): void
    {
        if (! $this->checkAuth("update", $this->product)) { return; }
        $this->product->category()->associate($this->chosenCategory);
        $this->product->save();
        $this->product->fresh();
        $this->displayCategory = false;
        session()->flash("product-success", "Категория успешно обновлена");
    }

    protected function findCategory(int $id): ?CategoryInterface
    {
        $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
        $category = $categoryModelClass::find($id);
        if (! $category) {
            $this->setCategoryList();
            session()->flash("category-error", "Категория не найдена");
            return null;
        }
        return $category;
    }

    protected function setCategoryList(): void
    {
        $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
        $query = $categoryModelClass::query()
            ->select("id", "title");
        BuilderActions::extendLike($query, $this->searchCategory, "title");
        $this->categoryList = $query->orderBy("title")->get();
    }
}
