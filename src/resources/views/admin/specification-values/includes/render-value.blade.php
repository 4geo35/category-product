@switch($item->specification->type)
    @case("color")
        @php($exploded = explode("|", $item->value))
        <div class="flex items-center justify-start space-x-2">
            <span class="w-4 h-4 rounded-full border border-light" style="background-color: {{ $exploded[0] }}"></span>
            <span>{{ $exploded[1] }}</span>
        </div>
        @break
    @default
        <span>{{ $item->value }}</span>
@endswitch
