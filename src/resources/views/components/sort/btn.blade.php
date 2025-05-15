@props(["data"])
<button type="button" class="flex w-full px-indent-half py-2 hover:bg-secondary/20"
        wire:click="applySort('{{ $data->by }}', '{{ $data->direction }}')">
    @includeIf("{$data->ico}")
    <span class="text-nowrap pl-indent-half">{{ $data->title }}</span>
</button>
