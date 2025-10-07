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
