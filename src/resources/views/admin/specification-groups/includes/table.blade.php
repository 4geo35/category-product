<x-tt::table drag-root >
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">Заголовок</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($groups as $key => $item)
            @can("order", config("category-product.customSpecificationGroupModel") ?? \GIS\CategoryProduct\Models\SpecificationGroup::class)
                <tr drag-item="{{ $item->id }}" drag-item-order="{{ $key }}" wire:key="{{ $item->id }}">
            @else
                <tr wire:key="{{ $item->id }}">
            @endcan
                <td class="align-middle">
                    <div class="flex items-center h-full">
                        @if (! $hasSearch)
                            <x-tt::ico.bars drag-grab class="text-secondary mr-indent cursor-grab" />
                        @endif
                        <span>{{ $item->title }}</span>
                    </div>
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
