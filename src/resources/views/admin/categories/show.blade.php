<x-admin-layout>
    <x-slot name="title">Просмотр категории</x-slot>
    <x-slot name="pageTitle">Просмотр категории</x-slot>

    <div class="space-y-indent">
        <livewire:cp-admin-category-show :category="$category" />
        <livewire:ma-metas :model="$category" />
    </div>
</x-admin-layout>
