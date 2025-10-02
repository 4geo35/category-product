@props(["product"])
@php($url = route("web.product", ["product" => $product]))

<div class="product-teaser flex h-full bg-white shadow-md rounded-base overflow-hidden">
{{--    @includeIf("pf::web.favorite.switcher")--}}
    <a href="{{ $url }}" class="block overflow-hidden 2xl:h-[342px]">
        @if ($product->cover)
            <picture>
                <img src="{{ route('thumb-img', ['template' => 'product-teaser', 'filename' => $product->cover->file_name]) }}"
                     alt="" class="">
            </picture>
        @else
            @include("cp::web.catalog.includes.product.empty")
        @endif
    </a>
    <div class="flex-auto p-indent">
        <a href="{{ $url }}" class="text-h4-mobile sm:text-h4 font-semibold hover:text-primary-hover">
            {{ $product->title }}
        </a>
    </div>
</div>
