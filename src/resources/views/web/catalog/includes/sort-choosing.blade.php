<div class="flex items-center justify-between lg:w-full">
    <x-tt::dropdown cover-button-class="">
        <x-slot name="button">
            <button type="button" class="h-full flex items-center hover:text-primary cursor-pointer">
                <x-cp::sort.text :options="$sortOptions" :by="$sortBy" :direction="$sortDirection" />
            </button>
        </x-slot>
        <x-slot name="content">
            @foreach($sortOptions as $option)
                <x-cp::sort.btn :data="$option" />
            @endforeach
        </x-slot>
    </x-tt::dropdown>

    <div class="hidden xl:flex items-center justify-end space-x-indent-half" wire:ignore>
        {{-- При изменении класса цвета кнопок, нужно их обнулить в product-list-wire --}}
        <button type="button" @click="chooseView('list')" x-ref="listButton"
                class="cursor-pointer {{ $gridView == 'list' ? 'text-primary' : 'text-primary/25' }} hover:text-primary-hover">
            <x-cp::ico.list />
        </button>
        <button type="button" @click="chooseView('card')" x-ref="cardButton"
                class="cursor-pointer {{ $gridView == 'list' ? 'text-primary/25' : 'text-primary' }} hover:text-primary-hover">
            <x-cp::ico.grid />
        </button>
    </div>
</div>
