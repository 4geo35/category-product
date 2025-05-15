<div>
    <x-tt::dropdown>
        <x-slot name="button">
            <button type="button" class="hover:text-primary cursor-pointer">
                <x-cp::sort.text :options="$sortOptions" :by="$sortBy" :direction="$sortDirection" />
            </button>
        </x-slot>
        <x-slot name="content">
            @foreach($sortOptions as $option)
                <x-cp::sort.btn :data="$option" />
            @endforeach
        </x-slot>
    </x-tt::dropdown>
</div>
