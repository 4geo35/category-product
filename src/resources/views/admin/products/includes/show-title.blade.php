<div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
    <h2 class="font-medium text-2xl text-nowrap mr-indent-half">
        {{ $product->title }}
    </h2>

    <div class="flex justify-end">
        <button type="button" class="btn btn-dark px-btn-x-ico rounded-e-none"
                @cannot("update", $product) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showEdit({{ $product->id }})">
            <x-tt::ico.edit />
        </button>
        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                @cannot("delete", $product) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showDelete({{ $product->id }})">
            <x-tt::ico.trash />
        </button>

        <button type="button" class="btn {{ $product->published_at ? 'btn-success' : 'btn-danger' }} px-btn-x-ico ml-indent-half"
                @cannot("update", $product) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="switchPublish({{ $product->id }})">
            @if ($product->published_at)
                <x-tt::ico.toggle-on />
            @else
                <x-tt::ico.toggle-off />
            @endif
        </button>
    </div>
</div>
