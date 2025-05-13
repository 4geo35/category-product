@props(["category"])
@php($url = route("web.category", ["category" => $category]))
<div class="flex flex-col h-full">
    <a href="{{ $url }}" class="block mb-indent-half flex-auto">
        @if ($category->image)
            <img src="{{ route('thumb-img', ['template' => 'col-4-square', 'filename' => $category->image->file_name]) }}" alt="">
        @else
            <span class="w-full h-full flex items-center justify-center p-indent">Empty</span>
        @endif
    </a>
    <a href="{{ $url }}" class="hover:text-primary-hover text-xl font-medium">
        <span>{{ $category->title }}</span>
    </a>
</div>
