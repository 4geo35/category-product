@props(["options", "by", "direction"])
@php
    if (empty($by)) $by = config("category-product.defaultSort");
    if (empty($direction)) $direction = config("category-product.defaultSortDirection")
@endphp
<span class="inline-flex items-center">
    @if (! empty($options["{$by}.{$direction}"]))
        @php($item = $options["{$by}.{$direction}"])
        @includeIf("{$item->ico}")
        <span class="text-nowrap pl-indent-half">{{ $item->title }}</span>
    @else
        Сортировка
    @endif
</span>
