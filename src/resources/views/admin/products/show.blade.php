<x-admin-layout>
    <x-slot name="title">Просмотр товара</x-slot>
    <x-slot name="pageTitle">Просмотр товара</x-slot>

    <div class="space-y-indent">
        <livewire:cp-admin-product-show :product="$product" />
        <livewire:fa-images :model="$product" />
        <livewire:ma-metas :model="$product" />
    </div>
</x-admin-layout>
