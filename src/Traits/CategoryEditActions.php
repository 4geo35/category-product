<?php

namespace GIS\CategoryProduct\Traits;

use GIS\CategoryProduct\Interfaces\CategoryInterface;
use GIS\CategoryProduct\Models\Category;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Mockery\Exception;

trait CategoryEditActions
{
    public bool $displayDelete = false;
    public bool $displayData = false;
    public bool $displayDeleteImage = false;

    public int|null $categoryId = null;
    public int|null $parentId = null;

    public string $title = "";
    public string $slug = "";
    public TemporaryUploadedFile|null $cover = null;
    public string|null $coverUrl = null;
    public string $short = "";
    public string $description = "";

    public function rules(): array
    {
        $uniqueCondition = "unique:categories,slug";
        if ($this->categoryId) { $uniqueCondition .= ",{$this->categoryId}"; }
        return [
            "title" => ["required", "string", "max:150"],
            "slug" => ["nullable", "string", "max:150", $uniqueCondition],
            "cover" => ["nullable", "image", "mimes:jpg,jpeg,png,webp"],
            "short" => ["nullable", "string", "max:250"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "cover" => "Обложка",
            "short" => "Краткое описание",
        ];
    }

    public function closeData(): void
    {
        $this->displayData = false;
        $this->resetFields();
    }

    public function showEdit(int $id): void
    {
        $this->categoryId = $id;
        $category = $this->findModel();
        if (!$category) { return; }
        if (! $this->checkAuth("update", $category)) { return; }

        $this->displayData = true;
        $this->title = $category->title;
        $this->slug = $category->slug;
        $this->short = $category->short;
        $this->description = $category->description;
        if ($category->image_id) {
            $category->load("image");
            $this->coverUrl = $category->image->storage;
        } else { $this->coverUrl = null; }
    }

    public function update(): void
    {
        $category = $this->findModel();
        if (!$category) { return; }
        if (! $this->checkAuth("update", $category)) { return; }
        $this->validate();

        $slugHasChanged = $this->slug !== $category->slug;

        $category->update([
            "title" => $this->title,
            "slug" => $this->slug,
            "short" => $this->short,
            "description" => $this->description,
        ]);
        $category->livewireImage($this->cover);
        session()->flash("success", "Категория успешно обновлена");
        $this->closeData();
        if (isset($this->category)) {
            $this->category = $category;
            if ($slugHasChanged) {
                $this->redirectRoute("admin.categories.show", ["category" => $this->category]);
            }
        }
    }

    public function showDelete(int $id): void
    {
        $this->categoryId = $id;
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("delete", $category)) { return; }

        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("delete", $category)) { return; }

        if ($category->children->count()) {
            session()->flash("error", "Невозможно удалить категорию, у которой есть дочерние категории");
            $this->closeDelete();
            return;
        }
        // TODO: check products

        try {
            $category->delete();
            session()->flash("success", "Категория успешно удалена");
        } catch (\Exception $exception) {
            session()->flash("error", "Ошибка при удалении категории");
        }
        $this->closeDelete();
        if (isset($this->category)) {
            $this->redirectRoute("admin.categories.index");
        }
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function switchPublish(int $id): void
    {
        $this->categoryId = $id;
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("update", $category)) { return; }

        $category->update([
            "published_at" => $category->published_at ? null : now(),
        ]);
        if (isset($this->category)) {
            $this->category = $category;
            $this->dispatch("switch-category-published");
        }
    }

    protected function resetFields(): void
    {
        $this->reset("title", "slug", "cover", "short", "description", "coverUrl", "categoryId", "parentId");
    }

    protected function checkAuth(string $action, CategoryInterface $category = null): bool
    {
        try {
            $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
            $this->authorize($action, $category ?? $categoryModelClass);
            return true;
        } catch (\Exception $exception) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }

    protected function findModel(int $id = null): ?CategoryInterface
    {
        $categoryModelClass = config("category-product.customCategoryModel") ?? Category::class;
        if ($id) { $category = $categoryModelClass::find($id); }
        else { $category = $categoryModelClass::find($this->categoryId); }
        if (! $category) {
            session()->flash("error", "Категория не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $category;
    }
}
