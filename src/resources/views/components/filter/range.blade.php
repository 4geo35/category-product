@props(["data", "isModal", "filterItems"])
@php
    $initFrom = $filterItems[$data->slug]['from'];
    $initTo = $filterItems[$data->slug]['to'];
@endphp
<div filter-steps-slider-cover data-step="1">
    <div class="flex justify-between items-center mb-indent-half">
        <div class="pr-indent-half flex-1">
            <input type="number" name="range-{{ $data->slug }}"
                   filter-from-input
                   aria-label="От" step="1"
                   min="{{ (int) $data->min }}"
                   max="{{ (int) $data->max }}"
                   data-value="{{ (int) $data->min }}"
                   data-init="{{ $initFrom }}"
                   wire:model="filterItems.{{ $data->slug }}.from"
                   class="form-control">
        </div>
        <div class="pl-indent-half flex-1">
            <input type="number" name="range-{{ $data->slug }}"
                   filter-to-input
                   aria-label="До" step="1"
                   min="{{ (int) $data->min }}"
                   max="{{ (int) $data->max }}"
                   data-value="{{ (int) $data->max }}"
                   data-init="{{ $initTo }}"
                   wire:model="filterItems.{{ $data->slug }}.to"
                   class="form-control">
        </div>
    </div>
    <div>
        <div filter-steps-slider wire:ignore></div>
    </div>
</div>
