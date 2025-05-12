<?php

namespace GIS\CategoryProduct\Livewire\Admin\SpecificationValues;

use GIS\CategoryProduct\Interfaces\ProductInterface;
use GIS\CategoryProduct\Interfaces\SpecificationValueInterface;
use GIS\CategoryProduct\Models\Specification;
use GIS\CategoryProduct\Models\SpecificationValue;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class ListWire extends Component
{
    public ProductInterface $product;

    public bool $displayData = false;
    public bool $displayDelete = false;
    public array $specificationList = [];

    public string $value = "";
    public string $expandValue = "";
    public string|null $specificationId = null;
    public int|null $valueId = null;

    public function rules(): array
    {
        // TODO: change for color
        return [
            "value" => ["required", "string", "max:50"],
            "specificationId" => ["required", "numeric", "exists:specifications,id"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "value" => "Значение",
            "specificationId" => "Характеристика",
        ];
    }

    public function render(): View
    {
        $specificationValues = $this->product
            ->specifications()
            ->select("specification_values.*", "specifications.id as s_id", "specifications.priority", "specifications.title")
            ->leftJoin("specifications", "specifications.id", "=", "specification_values.specification_id")
            ->orderBy("specifications.priority")
            ->get();

        return view("cp::livewire.admin.specification-values.list-wire", compact("specificationValues"));
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("update")) { return; }
        $this->setSpecificationList();
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("update")) { return; }
        $this->validate();
        // TODO: change for color
        $this->product->specifications()->create([
            "value" => $this->value,
            "specification_id" => $this->specificationId,
        ]);
        session()->flash("success", "Значение успешно добавлено");
        $this->closeData();
    }

    public function showEdit(int $valueId): void
    {
        $this->resetFields();
        $this->valueId = $valueId;
        $value = $this->findModel();
        if (! $value) { return; }
        if (! $this->checkAuth("update")) { return; }
        $this->setSpecificationList();
        $this->displayData = true;
        // TODO: chance for color
        $this->value = $value->value;
        $this->specificationId = $value->specification_id;
    }

    public function update(): void
    {
        $value = $this->findModel();
        if (! $value) { return; }
        if (! $this->checkAuth("update")) { return; }
        $this->validate();
        // TODO: change for color
        $value->update([
            "value" => $this->value,
            "specification_id" => $this->specificationId,
        ]);
        session()->flash("success", "Значение успешно обновлено");
        $this->closeData();
    }

    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function showDelete(int $valueId): void
    {
        $this->resetFields();
        $this->valueId = $valueId;
        $value = $this->findModel();
        if (! $value) { return; }
        if (! $this->checkAuth("update")) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $value = $this->findModel();
        if (! $value) { return; }
        if (! $this->checkAuth("update")) { return; }
        $value->delete();
        session()->flash("success", "Значение успешно удалено");
        $this->closeDelete();
    }

    protected function resetFields(): void
    {
        $this->reset(["value", "expandValue", "specificationId", "valueId"]);
    }

    protected function checkAuth(string $action): bool
    {
        try {
            $this->authorize($action, $this->product);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }

    protected function findModel(): ?SpecificationValueInterface
    {
        $valueModelClass = config("category-product.customSpecificationValueModel") ?? SpecificationValue::class;
        $value = $valueModelClass::find($this->valueId);
        if (! $value) {
            session()->flash("error", "Значение не найдено");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $value;
    }

    protected function setSpecificationList(): void
    {
        $specificationModelClass = config('category-product.customSpecificationModel') ?? Specification::class;
        $specifications = $specificationModelClass::query()
            ->select("id", "title")
            ->orderBy("title")
            ->get();
        $this->specificationList = [];
        foreach ($specifications as $specification) {
            $this->specificationList[] = (object) [
                "id" => $specification->id,
                "title" => $specification->title
            ];
        }
    }
}
