<x-tt::modal.aside wire:model="displayCategory">
    <x-slot name="title">Изменить категорию</x-slot>
    <x-slot name="content">
        <div class="space-y-indent">
            @if (! $chosenCategory)
                <div class="flex items-center">
                    <input type="text" class="form-control rounded-e-none" placeholder="Категория" aria-label="Категория" wire:model.live.400="searchCategory">
                    <button type="button" class="btn btn-dark rounded-s-none" wire:click="searchCategory = ''">
                        <x-tt::ico.cross />
                    </button>
                </div>
            @else
                <div class="space-y-indent-half">
                    <div class="font-semibold">Заменить {{ $product->category->title }} на {{ $chosenCategory->title }}?</div>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="btn btn-outline-dark" wire:click="cancelChose">Отменить</button>
                        <button type="button" class="btn btn-primary" wire:click="confirmChose">Подтвердить</button>
                    </div>
                </div>
            @endif
            <x-tt::notifications.error prefix="category-" />
            <x-tt::notifications.success prefix="category-" />
            @if (! $chosenCategory)
                <div class="space-y-indent-half">
                    @if(! empty($categoryList))
                        @foreach($categoryList as $item)
                            <div class="flex justify-between items-center flex-nowrap">
                                <div class="text-lg font-semibold mr-indent-half">{{ $item->title }}</div>
                                <button type="button" class="btn btn-outline-dark btn-sm" wire:click="chooseCategory({{ $item->id }})">Выбрать</button>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
    </x-slot>
</x-tt::modal.aside>
