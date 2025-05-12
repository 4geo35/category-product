<?php

namespace GIS\CategoryProduct\Livewire\Admin\SpecificationGroups;

use GIS\CategoryProduct\Interfaces\SpecificationGroupInterface;
use GIS\CategoryProduct\Models\SpecificationGroup;
use GIS\TraitsHelpers\Facades\BuilderActions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    public string $searchTitle = "";
    public bool $hasSearch = false;

    public bool $displayData = false;
    public bool $displayDelete = false;

    public string $title = "";
    public int|null $groupId = null;

    protected function queryString(): array
    {
        return [
            "searchTitle" => ["as" => "title", "except" => ""],
        ];
    }

    public function rules(): array
    {
        $uniqueCondition = "unique:specification_groups,title";
        if ($this->groupId) $uniqueCondition .= ",{$this->groupId}";
        return [
            "title" => ["required", "string", "max:150", $uniqueCondition]
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
        ];
    }

    public function render(): View
    {
        $this->hasSearch = false;
        $groupModelClass = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
        $query = $groupModelClass::query()
            ->select("id", "title");
        BuilderActions::extendLike($query, $this->searchTitle, "title");
        if (! empty($this->searchTitle)) { $this->hasSearch = true; }
        $groups = $query->orderBy("priority")->get();
        return view("cp::livewire.admin.specification-groups.index-wire", compact("groups"));
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

        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $groupModelClass = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
        $groupModelClass::create([
            "title" => $this->title,
        ]);
        session()->flash("success", "Группа успешно добавлена");
        $this->closeData();
        $this->dispatch("update-list");
    }

    public function showEdit(int $groupId): void
    {
        $this->resetFields();
        $this->groupId = $groupId;
        $group = $this->findModel();
        if (! $group) return;
        if (! $this->checkAuth("update", $group)) { return; }

        $this->displayData = true;
        $this->title = $group->title;
    }

    public function update(): void
    {
        $group = $this->findModel();
        if (! $group) return;
        if (! $this->checkAuth("update", $group)) { return; }
        $this->validate();
        $group->update([
            "title" => $this->title,
        ]);
        session()->flash("success", "Группа успешно обновлена");
        $this->closeData();
    }

    public function showDelete(int $groupId): void
    {
        $this->resetFields();
        $this->groupId = $groupId;
        $group = $this->findModel();
        if (! $group) return;
        if (! $this->checkAuth("delete", $group)) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $group = $this->findModel();
        if (! $group) return;
        if (! $this->checkAuth("delete", $group)) { return; }
        $group->delete();
        session()->flash("success", "Группа успешно удалена");
        $this->closeDelete();
        $this->dispatch("update-list");
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function reorderItems(array $newOrder): void
    {
        if (! $this->checkAuth("order")) { return; }
        foreach ($newOrder as $priority => $id) {
            $this->groupId = $id;
            $group = $this->findModel();
            if (! $group) continue;
            $group->priority = $priority;
            $group->save();
        }
        $this->resetFields();
    }

    protected function resetFields(): void
    {
        $this->reset("title", "groupId");
    }

    protected function findModel(): ?SpecificationGroupInterface
    {
        $groupModelClass = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
        $group = $groupModelClass::find($this->groupId);
        if (! $group) {
            session()->flash("error", "Группа не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $group;
    }

    protected function checkAuth(string $action, SpecificationGroupInterface $group = null): bool
    {
        try {
            $groupModelClass = config("category-product.customSpecificationGroupModel") ?? SpecificationGroup::class;
            $this->authorize($action, $group ?? $groupModelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
