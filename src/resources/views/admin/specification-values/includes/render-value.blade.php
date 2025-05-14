@switch($item->specification->type)
    @case("color")
        @php($color = $item->color)
        <div class="flex items-center justify-start space-x-2">
            <span class="w-4 h-4 rounded-full border border-light" style="background-color: {{ $color->hash }}"></span>
            <span>{{ $item->value }}</span>
        </div>
        @break
    @default
        <span>{{ $item->value }}</span>
@endswitch
