<x-admin-layout>
    <x-slot name="title">Категории</x-slot>
    <x-slot name="pageTitle">Категории</x-slot>

    <livewire:cp-admin-category-list />

    @include("tt::admin.draggable-tree-script")
</x-admin-layout>
