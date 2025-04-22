<?php

namespace GIS\CategoryProduct\Livewire\Admin\Categories;

use GIS\CategoryProduct\Facades\CategoryActions;
use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Models\Category;
use GIS\CategoryProduct\Traits\CategoryEditActions;
use GIS\TraitsHelpers\Interfaces\WireTreeInterface;
use GIS\TraitsHelpers\Interfaces\WireTreePublishInterface;
use GIS\TraitsHelpers\Traits\WireDeleteImageTrait;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListWire extends Component implements WireTreeInterface, WireTreePublishInterface
{
    use WithFileUploads, WireDeleteImageTrait;
    use CategoryEditActions;

    public array|null $tmpTree = null;

    public function render(): View
    {
        $tree = CategoryActions::getCategoryTree($this->tmpTree);
        $this->dispatch("re-init-script");
        return view('cp::livewire.admin.categories.list-wire', compact('tree'));
    }

    public function showCreate(int $parentId = null): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }

        $this->parentId = $parentId;
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        if ($this->parentId) {
            $parent = $this->findModel($this->parentId);
            if (! $parent) { return; }
        }
        $this->validate();
        $data = [
            "title" => $this->title,
            "slug" => $this->slug,
            "short" => $this->short,
            "description" => $this->description,
        ];
        if ($this->parentId) {
            $category = $parent->children()->create($data);
        } else {
            $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
            $category = $categoryModelClass::create($data);
        }
        /**
         * @var CategoryInterface $category
         */
        $category->livewireImage($this->cover);
        session()->flash("success", "Категория успешно добавлена");
        $this->closeData();
    }

    public function tmpOrder(array $tree): void
    {
        $this->tmpTree = $tree;
        $this->dispatch("change-tree");
    }

    public function updateOrder(): void
    {
        if (! $this->checkAuth("order")) { return; }
        $result = CategoryActions::rebuildTree($this->tmpTree);
        $this->tmpTree = null;
        if ($result) { session()->flash("success", "Дерево категорий изменено"); }
        else { session()->flash("error", "Ошибка при обновлении дерева"); }
    }
}
