<form id="formFilter{{ $isModal ? 'Modal' : '' }}" class="space-y-indent-half" wire:submit.prevent="applyFilters">
    @foreach($filters as $filter)
        <div wire:key="{{ $filter->id }}">
            @switch($filter->type)
                @case("checkbox")
                    <livewire:cp-checkbox-filter :data="$filter" :key="$filter->id" wire:model="filterItems.{{ $filter->slug }}" :is-modal="$isModal" />
                    @break
                @case("color")
                    <livewire:cp-color-filter :data="$filter" :key="$filter->id" wire:model="filterItems.{{ $filter->slug }}" :is-modal="$isModal" />
                    @break
                @case("range")
                    <x-cp::filter.range :data="$filter" :is-modal="$isModal" :filter-items="$filterItems" />
                    @break
            @endswitch
        </div>
    @endforeach

        <div class="space-y-indent-half" x-data>
            <button type="submit" form="formFilter{{ $isModal ? 'Modal' : '' }}"
                    @click="($el.closest('body') || document.querySelector('body')).scrollIntoView(); @if ($isModal) $dispatch('toggle_mobile_filter') @endif"
                    class="btn btn-primary block w-full">
                Применить
            </button>
            <button type="button" class="btn btn-outline-secondary block w-full"
                    @click="($el.closest('body') || document.querySelector('body')).scrollIntoView(); @if ($isModal) $dispatch('toggle_mobile_filter') @endif"
                    wire:click="resetFilters">
                Сбросить фильтры
            </button>
        </div>
</form>
