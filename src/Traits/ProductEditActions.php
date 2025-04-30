<?php

namespace GIS\CategoryProduct\Traits;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\CategoryProduct\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;

trait ProductEditActions
{
    public bool $displayData = false;
    public bool $displayDelete = false;

    public string $title = "";
    public string $slug = "";
    public string $short = "";
    public string $description = "";

    public int|null $productId = null;

    public function rules(): array
    {
        $uniqueCondition = "unique:services,slug";
        if ($this->productId != null) { $uniqueCondition .= "," . $this->productId; }
        return [
            "title" => ["required", "string", "max:150"],
            "slug" => ["nullable", "string", "max:150", $uniqueCondition],
            "short" => ["nullable", "string", "max:150"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "short" => "Краткое описание",
        ];
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showEdit(int $productId): void
    {
        $this->resetFields();
        $this->productId = $productId;
        $product = $this->findModel();
        if (! $product) { return; }
        if (! $this->checkAuth("update", $product)) { return; }

        $this->title = $product->title;
        $this->slug = $product->slug;
        $this->short = $product->short;
        $this->description = $product->description;
        $this->displayData = true;
    }

    public function update(): void
    {
        $product = $this->findModel();
        if (! $product) { return; }
        if (! $this->checkAuth("update", $product)) { return; }
        $this->validate();

        $slugHasChanged = $this->slug !== $product->slug;

        $product->update([
            "title" => $this->title,
            "slug" => $this->slug,
            "short" => $this->short,
            "description" => $this->description,
        ]);
        session()->flash("product-success", "Товар успешно обновлен");
        $this->closeData();
        if (method_exists($this, 'resetPage')) { $this->resetPage(); }
        if (isset($this->product)) {
            $this->product->fresh();
            if ($slugHasChanged) {
                $this->redirectRoute("admin.products.show", ["product" => $this->product]);
            }
        }
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function showDelete(int $productId): void
    {
        $this->resetFields();
        $this->productId = $productId;
        $product = $this->findModel();
        if (! $product) { return; }
        if (! $this->checkAuth("delete", $product)) { return; }

        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $product = $this->findModel();
        if (! $product) { return; }
        if (! $this->checkAuth("delete", $product)) { return; }

        $category = $product->category;
        /**
         * @var CategoryInterface $category
         */

        try {
            $product->delete();
            session()->flash("product-success", "Товар успешно удален");
        } catch (\Exception $exception) {
            session()->flash("product-error", "Ошибка при удалении товара");
        }

        $this->closeDelete();
        if (method_exists($this, 'resetPage')) { $this->resetPage(); }
        if (isset($this->product)) {
            $this->redirectRoute("admin.categories.show", ["category" => $category]);
        }
    }

    public function switchPublish(int $productId): void
    {
        $this->resetFields();
        $this->productId = $productId;
        $product = $this->findModel();
        if (! $product) { return; }
        if (! $this->checkAuth("update", $product)) { return; }

        $product->update([
            "published_at" => $product->published_at ? null : now(),
        ]);
        if (isset($this->product)) { $this->product->fresh(); }
    }

    protected function findModel(): ?ProductInterface
    {
        if (isset($this->product)) return $this->product;

        $productModelClass = config("category-product.customProductModel") ?? Product::class;
        $product = $productModelClass::find($this->productId);
        if (! $product) {
            session()->flash("product-error", "Товар не найден");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $product;
    }

    protected function resetFields(): void
    {
        $this->reset(["title", "slug", "short", "description", "productId"]);
    }

    protected function checkAuth(string $action, ProductInterface $product = null): bool
    {
        try {
            $productModelClass = config("category-product.customProductModel") ?? Product::class;
            $this->authorize($action, $product ?? $productModelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("service-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
