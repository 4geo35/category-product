<div class="container">
    <div class="row">
        <div class="col w-full md:w-5/12">
            @if ($images->count())
                <div id="swiperMain" class="swiper main-swiper w-[578px] h-[578px] overflow-hidden mb-indent-half">
                    <div class="swiper-wrapper">
                        @foreach($images as $image)
                            <div class="swiper-slide">
                                <a data-fslightbox="lightbox-{{ $product->id }}"
                                   href="{{ route('thumb-img', ['template' => 'original', 'filename' => $image->file_name]) }}">
                                    <img src="{{ route('thumb-img', ['template' => 'product-show', 'filename' => $image->file_name]) }}"
                                     alt="" class="rounded-base">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="swiperThumb" class="swiper thumb-swiper w-[578px] h-[77px] overflow-hidden" thumbsSlider="">
                    <div class="swiper-wrapper">
                        @foreach($images as $image)
                            <div class="swiper-slide flex items-center justify-center !w-[77px] !h-[77px] cursor-pointer">
                                <img src="{{ route('thumb-img', ['template' => 'product-show-thumb', 'filename' => $image->file_name]) }}"
                                     alt="" class="rounded-base">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="col w-full md:w-5/12 mx-auto">
            <div class="space-y-indent">
                @if ($product->short)
                    <div class="text-body/60">{{ $product->short }}</div>
                @endif

                @if (count($product->specification_list))
                    <ul >
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
{{--                @includeIf("pv::web.variations.show")--}}
            </div>
        </div>
    </div>
</div>

@include("cp::web.catalog.includes.product.swiper-script")
