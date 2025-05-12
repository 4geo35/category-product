<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">Характеристика</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Значение</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($specificationValues as $item)
            <tr>
                <td>
                    <a href="{{ route('admin.specifications.index') }}?title={{ $item->title }}"
                       class="text-info hover:text-info-hover">
                        {{ $item->title }}
                    </a>
                </td>
                <td>
                    @include("cp::admin.specification-values.includes.render-value")
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
