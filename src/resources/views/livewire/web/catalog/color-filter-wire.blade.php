<div>
    @if ($needSearch)
        <div class="mb-indent-half">
            <label for="search-{{ $data->slug }}{{ $isModal ? '-modal' : '' }}" class="inline-block mb-2">
                <span class="text-h4-mobile sm:text-h4 font-semibold">{{ $data->title }}</span>
            </label>
            <input type="text" id="search-{{ $data->slug }}{{ $isModal ? '-modal' : '' }}"
                   class="form-control"
                   wire:model.live="search">
        </div>
    @else
        <div class="mb-indent-half">
            <span class="text-h4-mobile sm:text-h4 font-semibold">{{ $data->title }}</span>
        </div>
    @endif
    @foreach($filteredValues as $item)
        <div class="form-check" :key="$item['id']">
            <input type="checkbox" wire:model.live="values"
                   class="form-check-input" id="{{ $item['inputId'] }}{{ $isModal ? '-modal' : '' }}"
                   value="{{ $item['value'] }}">
            <label for="{{ $item['inputId'] }}{{ $isModal ? '-modal' : '' }}" class="form-check-label">
                <x-cp::specification.color :color="$item['color']" :title="$item['value']" />
            </label>
        </div>
    @endforeach
    <div class="flex justify-between items-center">
        @if ($hasMore)
            <button type="button" class="text-primary hover:text-primary-hover" wire:click="switchCollapse">
                @if ($showMore)
                    Еще {{ $showMore }}
                @else
                    Меньше
                @endif
            </button>
        @endif
        @if (count($values) > 0)
            <div class="text-secondary">Выбрано {{ count($values) }}</div>
        @endif
    </div>
</div>
