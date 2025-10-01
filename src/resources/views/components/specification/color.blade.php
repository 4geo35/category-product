@props(["color", "title"])
<span class="inline-flex items-center space-x-2">
    <span class="w-4 h-4 rounded-full inline-block"
          style="background-color: {{ $color }}"></span>
    <span>{{ $title }}</span>
</span>
