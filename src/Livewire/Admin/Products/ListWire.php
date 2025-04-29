<?php

namespace GIS\CategoryProduct\Livewire\Admin\Products;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Models\Product;
use GIS\CategoryProduct\Traits\ProductEditActions;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ListWire extends Component
{
    use WithPagination, ProductEditActions;

    public CategoryInterface|null $category = null;

    public string $searchTitle = "";
    public string $searchPublished = "all";

    public string|null $updateDate = null;

    protected function queryString(): array
    {
        return [
            "searchTitle" => ["as" => "title", "except" => ""],
            "searchPublished" => ["as" => "published", "except" => "all"],
        ];
    }

    public function mount(): void
    {
        $this->setUpdateTime();
    }

    public function render(): View
    {
        if ($this->category) { $query = $this->category->products(); }
        else {
            $productModelClass = config("category-product.customProductModel") ?? Product::class;
            $query = $productModelClass::query()->with("category");
        }
        BuilderActions::extendLike($query, $this->searchTitle, "title");
        BuilderActions::extendPublished($query, $this->searchPublished);
        $query->orderBy("title");
        $products = $query->paginate();
        $time = $this->updateDate;
        return view('cp::livewire.admin.products.list-wire', compact('products', "time"));
    }

    #[On("switch-category-published")]
    public function setUpdateTime(): void
    {
        $this->updateDate = now()->format("Y-m-d H:i:s");
    }

    public function clearSearch(): void
    {
        $this->reset("searchTitle", "searchPublished");
        $this->resetPage();
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }

        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $product = $this->category->products()->create([
            "title" => $this->title,
            "slug" => $this->slug,
            "short" => $this->short,
            "description" => $this->description,
        ]);
        $this->closeData();
        $this->redirectRoute("admin.products.show", ["product" => $product]);
    }
}
