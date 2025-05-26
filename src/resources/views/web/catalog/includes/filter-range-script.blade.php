@push("scripts")
    <script type="text/javascript">
        (function () {
            document.addEventListener("DOMContentLoaded", function () {
                setTimeout(initRanges, 100)
            })
            // Нужно обновить слайдер при сбросе фильтров
            Livewire.on("filter-ready-for-render", function () {
                setTimeout(applyInputs, 100)
            })

            function applyInputs() {
                document.querySelectorAll("[filter-steps-slider-cover]").forEach(el => {
                    let stepsSlider = el.querySelector('[filter-steps-slider]')
                    if (typeof stepsSlider.noUiSlider === "object") {
                        let from = el.querySelector('[filter-from-input]')
                        let to = el.querySelector('[filter-to-input]')
                        stepsSlider.noUiSlider.set([parseInt(from.getAttribute('data-init')), parseInt(to.getAttribute('data-init'))])
                    }
                })
            }

            function initRanges() {
                document.querySelectorAll("[filter-steps-slider-cover]").forEach(el => {
                    let stepsSlider = el.querySelector('[filter-steps-slider]')
                    let from = el.querySelector('[filter-from-input]')
                    let to = el.querySelector('[filter-to-input]')
                    let inputs = [from, to]
                    let min = parseInt(from.getAttribute('data-value'))
                    let max = parseInt(to.getAttribute('data-value'))
                    let range = [parseInt(from.getAttribute('data-init')), parseInt(to.getAttribute('data-init'))]
                    let step = parseInt(el.getAttribute('data-step'))
                    if (isNaN(step)) step = 10

                    noUiSlider.create(stepsSlider, {
                        start: range,
                        connect: true,
                        step: step,
                        range: {
                            'min': min,
                            'max': max
                        },
                        format: {
                            from: function (value) {
                                return parseInt(value)
                            },
                            to: function (value) {
                                return parseInt(value)
                            }
                        }
                    })

                    stepsSlider.noUiSlider.on('update', function (values, handle) {
                        inputs[handle].value = values[handle]
                        inputs[handle].dispatchEvent(new Event("input", { bubbles: true }))
                    })

                    from.addEventListener('change', function () {
                        stepsSlider.noUiSlider.set([this.value, null])
                    })

                    to.addEventListener('change', function () {
                        stepsSlider.noUiSlider.set([null, this.value])
                    })
                })
            }
        })()
    </script>
@endpush
