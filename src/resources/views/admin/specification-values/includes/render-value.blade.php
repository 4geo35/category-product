@switch($item->specification->type)
    @case("color")
        @php($exploded = explode("|", $item->value))
        <span class="px-2 py-1 rounded-base" style="background-color: {{ $exploded[0] }}">{{ $exploded[1] }}</span>
        @break
    @default
        <span>{{ $item->value }}</span>
@endswitch
