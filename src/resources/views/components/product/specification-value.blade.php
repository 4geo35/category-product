@props(["value"])
<div class="row">
    <div class="col w-full xl:w-1/2 xl:mb-2 text-body/60">
        {{ $value->title }}
    </div>
    <div class="col w-full xl:w-1/2 mb-2">
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
