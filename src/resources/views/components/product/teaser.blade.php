@props(["product"])
@php($url = route("web.product", ["product" => $product]))

<div class="product-teaser flex h-full bg-white shadow-md rounded-base overflow-hidden">
{{--    @includeIf("pf::web.favorite.switcher")--}}
    <a href="{{ $url }}" class="shrink-0 block overflow-hidden sm:h-[258px] sm:w-[258px] md:w-[216px] md:h-[216px] lg:h-[336px] lg:w-[336px] xl:h-[276px] xl:w-[276px] 2xl:h-[342px] 2xl:w-[342px]">
        @if ($product->cover)
            <picture>
                <source media="(min-width: 640px)"
                        srcset="{{ route('thumb-img', ['template' => "product-teaser", 'filename' => $product->cover->file_name]) }}">
                <img src="{{ route('thumb-img', ['template' => 'mobile-product-teaser', 'filename' => $product->cover->file_name]) }}"
                     alt="" class="">
            </picture>
        @else
            @include("cp::web.catalog.includes.product.empty")
        @endif
    </a>
    <div class="flex-auto flex flex-col justify-between p-indent-half lg:p-indent">
        <a href="{{ $url }}" class="text-h4-mobile sm:text-h4 font-semibold hover:text-primary-hover">
            {{ $product->title }}
        </a>
        <div class="mt-indent">
            @if ($product->short)
                <div class="{{ count($product->specification_list) ? 'product-short' : '' }} text-sm lg:text-base text-body/60 overflow-hidden">
                    {{ $product->short }}
                </div>
            @endif
            @if (count($product->specification_list))
                <ul class="product-specifications mb-indent">
                    @foreach($product->specification_list as $specification)
                        <li class="row">
                            <div class="col w-full xl:w-1/2 xl:mb-2 text-body/60">
                                {{ $specification->title }}
                            </div>
                            <div class="col w-full xl:w-1/2 mb-2">
                                {{ $specification->stringValues }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
{{--        <div>--}}
{{--            --}}{{-- TODO: add price --}}
{{--        </div>--}}
    </div>
</div>
