<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить значение</x-slot>
    <x-slot name="text">Будет невозможно восстановить значение!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">{{ $valueId ? "Редактировать" : "Добавить" }} значение</x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $valueId ? 'update' : 'store' }}" class="space-y-indent-half" id="valuesDataForm">
            <div>
                <label for="specificationId" class="inline-block mb-2">
                    Характеристика<span class="text-danger">*</span>
                </label>
                <select class="form-select {{ $errors->has('specificationId') ? 'border-danger' : '' }}"
                        id="specificationId" required
                        wire:model.live="specificationId"
                        @if ($valueId) disabled @else wire:loading.attr="disabled" @endif>
                    <option value="">Выберите характеристику</option>
                    @foreach($specificationList as $item)
                        <option value="{{ $item->id }}" wire:key="{{ $item->id }}">
                            {{ $item->title }}
                        </option>
                    @endforeach
                </select>
                <x-tt::form.error name="specificationId" />
            </div>

            @include("cp::admin.specification-values.includes.value-fields")

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="valuesDataForm" class="btn btn-primary"
                        wire:loading.attr="disabled">
                    {{ $valueId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
