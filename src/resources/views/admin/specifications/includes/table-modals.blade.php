<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить характеристику</x-slot>
    <x-slot name="text">Будет невозможно восстановить характеристику!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayProducts">
    <x-slot name="title">Товары</x-slot>
    <x-slot name="content">
        <ul>
            @foreach($productList as $item)
                <li>
                    <div class="flex justify-between">
                        <a href="{{ $item->url }}" class="text-info hover:text-info-hover">{{ $item->title }}</a>
                        <div>{{ $item->value }}</div>
                    </div>
                </li>
            @endforeach
        </ul>
    </x-slot>
</x-tt::modal.aside>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $specificationId ? "Редактировать" : "Добавить" }} характеристику</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $specificationId ? 'update' : 'store' }}"
              class="space-y-indent-half" id="specificationDataForm">
            <div>
                <label for="title" class="inline-block mb-2">
                    Заголовок<span class="text-danger">*</span>
                </label>
                <input type="text" id="title"
                       class="form-control {{ $errors->has("title") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="title">
                <x-tt::form.error name="title"/>
            </div>

            <div>
                <label for="slug" class="inline-block mb-2">
                    Адресная строка
                </label>
                <input type="text" id="slug"
                       class="form-control {{ $errors->has("slug") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="slug">
                <x-tt::form.error name="slug"/>
            </div>

            @if (! $specificationId)
                <div>
                    <label for="type" class="inline-block mb-2">
                        Тип<span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="type" wire:model.live="type">
                        @foreach(config("category-product.specificationTypes") as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div>
                <label for="groupId" class="inline-block mb-2">
                    Группа
                </label>
                <select class="form-select {{ $errors->has("groupId") ? "border-danger" : "" }}"
                        id="groupId"
                        wire:model="groupId"
                        wire:loading.attr="disabled">
                    <option>Выберите группу</option>
                    @foreach($groupList as $group)
                        <option value="{{ $group->id }}" wire:key="{{ $group->id }}">{{ $group->title }}</option>
                    @endforeach
                </select>
                <x-tt::form.error name="groupId" />
            </div>

            <div class="form-check">
                <input type="checkbox" wire:model="inFilter" id="inFilter"
                       class="form-check-input {{ $errors->has('inFilter') ? 'border-danger' : '' }}"/>
                <label for="inFilter" class="form-check-label">
                    Добавить в фильтр
                </label>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">Отмена</button>
                <button type="submit" form="specificationDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $specificationId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
