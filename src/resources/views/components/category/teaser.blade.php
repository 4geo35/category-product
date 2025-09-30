@props(["category"])
@php($url = route("web.category", ["category" => $category]))

<div class="flex flex-col h-full bg-white shadow-md rounded-base">
    <a href="{{ $url }}" class="block overflow-hidden md:h-[252px] lg:h-[222px] xl:h-[208px] 2xl:h-[257px]">
        @if ($category->image)
            <picture>
                <source media="(min-width: 768px)"
                        srcset="{{ route('thumb-img', ['template' => "category-teaser", 'filename' => $category->image->file_name]) }}">
                <source media="(min-width: 480px)"
                        srcset="{{ route('thumb-img', ['template' => "tablet-category-teaser", 'filename' => $category->image->file_name]) }}">
                <img src="{{ route('thumb-img', ['template' => 'mobile-category-teaser', 'filename' => $category->image->file_name]) }}"
                     alt="" class="rounded-t-base">
            </picture>
        @else
            @include("cp::web.catalog.includes.catalog.empty")
        @endif
    </a>
    <div class="flex items-start justify-between p-indent flex-auto">
        <a href="{{ $url }}" class="text-h4-mobile sm:text-h4 font-semibold hover:text-primary-hover transition-all {{ $category->short ? 'mb-indent-half' : '' }}">
            {{ $category->title }}
        </a>
        @include("cp::web.catalog.includes.catalog.short")
    </div>
</div>
