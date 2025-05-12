<x-tt::table drag-root>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">Заголовок</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Адресная строка</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Тип</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Группа</x-tt::table.heading>
            <x-tt::table.heading class="text-left">В фильтре</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Значения</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($specifications as $key => $item)
            <tr drag-item="{{ $item->id }}" drag-item-order="{{ $key }}" wire:key="{{ $item->id }}">
                <td class="align-middle">
                    <div class="flex items-center h-full">
                        @if (! $hasSearch)
                            <x-tt::ico.bars drag-grab class="text-secondary mr-indent cursor-grab" />
                        @endif
                        <span>{{ $item->title }}</span>
                    </div>
                </td>
                <td>{{ $item->slug }}</td>
                <td>{{ config("category-product.specificationTypes")[$item->type] }}</td>
                <td>
                    @if ($item->group_id)
                        <a href="{{ route('admin.specification-groups.index') }}?title={{ $item->group->title }}"
                           class="text-info hover:text-info-hover">
                            {{ $item->group->title }}
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $item->in_filter ? "Да" : "Нет" }}</td>
                <td>
                    @if ($item->products->count() > 0)
                        <button type="button" class="text-info hover:text-info-hover cursor-pointer"
                                wire:click="showProducts({{ $item->id }})">
                            {{ $item->products->count() }}
                        </button>
                    @else
                        {{ $item->products->count() }}
                    @endif
                </td>
                <td>
                    <div class="flex justify-center">
                        <button type="button" class="btn btn-dark px-btn-x-ico rounded-e-none"
                                wire:loading.attr="disabled"
                                wire:click="showEdit({{ $item->id }})">
                            <x-tt::ico.edit />
                        </button>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                wire:loading.attr="disabled"
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash />
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
