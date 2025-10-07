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
            <div>{{ $product->short }}</div>
            @includeIf("pv::web.variations.show")
        </div>
    </div>
</div>

@push("scripts")
    <script type="application/javascript">
        (function () {
            document.addEventListener("DOMContentLoaded", function () {
                const sliderElement = document.getElementById("swiperMain")
                if (sliderElement) { initMainSlider(); }
            })
        })()

        function initMainSlider() {
            let thumbSwiper = new Swiper(".thumb-swiper", {
                slidesPerView: "auto",
                spaceBetween: 10,

                simulateTouch: true,
                watchOverflow: true,

                freeMode: true,
                watchSlidesProgress: true,
            })

            let swiper = new Swiper('.main-swiper', {
                loop: true,
                simulateTouch: true,
                spaceBetween: 24,
                thumbs: {
                    swiper: thumbSwiper
                }
            })
        }
    </script>
@endpush
