@props(["value"])
<div class="flex items-center justify-between">
    <div class="font-semibold">
        {{ $value->title }}
    </div>
    <div>
        @foreach($value->values as $item)
            @if ($value->type === "color")
                @php($exploded = explode("|", $item))
                @php($title = $exploded[0])
                @php($title .= $loop->last ? "" : ",")
                <x-cp::specification.color :color="$exploded[1]" :title="$title" />
            @else
                <span>{{ $item }}{{ $loop->last ? "" : "," }}</span>
            @endif
        @endforeach
    </div>
</div>
