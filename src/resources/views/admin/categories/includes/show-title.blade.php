<div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
    <h2 class="font-medium text-2xl text-nowrap mr-indent-half">
        {{ $category->title }}
    </h2>

    <div class="flex justify-end">
        <button type="button" class="btn btn-dark px-btn-x-ico rounded-e-none"
                @cannot("update", $category) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showEdit({{ $category->id }})">
            <x-tt::ico.edit />
        </button>
        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                @cannot("delete", $category) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="showDelete({{ $category->id }})">
            <x-tt::ico.trash />
        </button>

        <button type="button" class="btn {{ $category->published_at ? 'btn-success' : 'btn-danger' }} px-btn-x-ico ml-indent-half"
                @cannot("update", $category) disabled
                @else wire:loading.attr="disabled"
                @endcannot
                wire:click="switchPublish({{ $category->id }})">
            @if ($category->published_at)
                <x-tt::ico.toggle-on />
            @else
                <x-tt::ico.toggle-off />
            @endif
        </button>
    </div>
</div>
