<?php

namespace GIS\CategoryProduct\Livewire\Admin\Specifications;

use GIS\CategoryProduct\Interfaces\SpecificationInterface;
use GIS\CategoryProduct\Interfaces\SpecificationValueInterface;
use GIS\CategoryProduct\Models\Specification;
use GIS\CategoryProduct\Models\SpecificationGroup;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    public string $searchTitle = "";
    public bool $hasSearch = false;

    public bool $displayData = false;
    public bool $displayDelete = false;
    public bool $displayProducts = false;

    public string $title = "";
    public string $slug = "";
    public string|null $groupId = null;
    public string $type = "checkbox";
    public bool $inFilter = false;

    public int|null $specificationId = null;
    public array $groupList = [];
    public array $productList = [];

    protected function queryString(): array
    {
        return [
            "searchTitle" => ["as" => "title", "except" => ""]
        ];
    }

    public function rules(): array
    {
        $uniqueTitleCondition = "unique:specifications,title";
        if ($this->specificationId) $uniqueTitleCondition .= ",{$this->specificationId}";
        $uniqueSlugCondition = "unique:specifications,slug";
        if ($this->specificationId) $uniqueSlugCondition .= ",{$this->specificationId}";
        $existCondition = $this->groupId > 0 ? "exists:specification_groups,id" : "";
        $data = [
            "title" => ["required", "string", "max:150", $uniqueTitleCondition],
            "slug" => ["nullable", "string", "max:150", $uniqueSlugCondition],
            "groupId" => ["nullable", "numeric", $existCondition],
        ];
        if (! $this->specificationId)
            $data["type"] = ["required", "string", Rule::in(array_keys(config("category-product.specificationTypes")))];
        return $data;
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
            "groupId" => "Группа",
            "type" => "Тип",
            "slug" => "Адресная строка",
        ];
    }

    public function render(): View
    {
        $this->setGroupList();
        $this->hasSearch = ! empty($this->searchTitle);
        $specificationModelClass = config("category-product.customSpecificationModel") ?? Specification::class;
        $query = $specificationModelClass::query()
            // TODO: optimize products count and show list
            ->with(["group:id,title", "products"]);
        BuilderActions::extendLike($query, $this->searchTitle, "title");
        $specifications = $query
            ->orderBy("priority")
            ->get();
        return view("cp::livewire.admin.specifications.index-wire", compact("specifications"));
    }

    public function clearSearch(): void
    {
        $this->reset("searchTitle");
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }
        $this->setGroupList();
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $specificationModelClass = config("category-product.customSpecificationModel") ?? Specification::class;
        $specificationModelClass::create([
            "title" => $this->title,
            "slug" => $this->slug,
            "type" => $this->type,
            "group_id" => $this->groupId <= 0 ? null : $this->groupId,
            "in_filter" => $this->inFilter ? now() : null,
        ]);
        session()->flash("success", "Характеристика успешно добавлена");
        $this->closeData();
        $this->dispatch("update-list");
    }

    public function showEdit(int $specificationId): void
    {
        $this->resetFields();
        $this->specificationId = $specificationId;
        $specification = $this->findModel();
        if (! $specification) { return; }
        if (! $this->checkAuth("update", $specification)) { return; }

        $this->setGroupList();
        $this->displayData = true;
        $this->title = $specification->title;
        $this->slug = $specification->slug;
        $this->type = $specification->type;
        $this->groupId = $specification->group_id ?? 0;
        $this->inFilter = (bool)$specification->in_filter;
    }

    public function update(): void
    {
        $specification = $this->findModel();
        if (! $specification) { return; }
        if (! $this->checkAuth("update", $specification)) { return; }
        $this->validate();

        $specification->update([
            "title" => $this->title,
            "slug" => $this->slug,
            "group_id" => $this->groupId <= 0 ? null : $this->groupId,
            "in_filter" => $this->inFilter ? now() : null,
        ]);
        session()->flash("success", "Характеристика успешно обновлена");
        $this->closeData();
    }

    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function showDelete(int $specificationId): void
    {
        $this->resetFields();
        $this->specificationId = $specificationId;
        $specification = $this->findModel();
        if (! $specification) { return; }
        if (! $this->checkAuth("delete", $specification)) { return; }

        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $specification = $this->findModel();
        if (! $specification) { return; }
        if (! $this->checkAuth("delete", $specification)) { return; }
        $specification->delete();
        session()->flash("success", "Характеристика успешно удалена");
        $this->closeDelete();
    }

    public function reorderItems(array $newOrder): void
    {
        if (! $this->checkAuth("order")) { return; }
        foreach ($newOrder as $priority => $id) {
            $this->specificationId = $id;
            $specification = $this->findModel();
            if (! $specification) { continue; }
            $specification->priority = $priority;
            $specification->save();
        }
        $this->resetFields();
    }

    public function showProducts(int $specificationId): void
    {
        $this->resetFields();
        $this->specificationId = $specificationId;
        $specification = $this->findModel();
        if (! $specification) { return; }

        $this->displayProducts = true;
        $specification->load("products");
        foreach ($specification->products as $item) {
            /**
             * @var SpecificationValueInterface $item
             */
            $this->productList[] = (object)[
                "value" => $item->value,
                "title" => $item->product->title,
                "url" => route("admin.products.show", ["product" => $item->product]),
            ];
        }
    }

    protected function checkAuth(string $action, SpecificationInterface $specification = null): bool
    {
        try {
            $specificationModelClass = config("category-product.customSpecificationModel") ?? Specification::class;
            $this->authorize($action, $specification ?? $specificationModelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }

    protected function findModel(): ?SpecificationInterface
    {
        $specificationModelClass = config("category-product.customSpecificationModel") ?? Specification::class;
        $specification = $specificationModelClass::find($this->specificationId);
        if (! $specification) {
            session()->flash("error", "Характеристика не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $specification;
    }

    protected function resetFields(): void
    {
        $this->reset(["title", "specificationId", "groupList", "groupId", "productList", "type", "inFilter", "slug"]);
    }

    protected function setGroupList(): void
    {
        $groupModelClass = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
        $groups = $groupModelClass::query()
            ->select("id", "title")
            ->orderBy("title")
            ->get();
        $this->groupList = [];
        foreach ($groups as $group) {
            $this->groupList[] = (object) [
                "id" => $group->id,
                "title" => $group->title,
            ];
        }
    }
}
