<x-app-layout>
    @include("cp::web.catalog.includes.category-metas")
    @include("cp::web.catalog.includes.category-breadcrumbs")

    <div class="container">
        <div class="row">
            <div class="col w-1/4">
                <livewire:cp-category-filter :category="$category" />
            </div>
            <div class="col w-3/4">
                <x-tt::h1 class="mb-indent-half">{{ $category->title }}</x-tt::h1>
                @include("cp::web.catalog.includes.sub-categories")
                <livewire:cp-product-list :category="$category" />
            </div>
        </div>
    </div>

{{--    @push("modals")--}}
{{--        <x-tt::modal.aside id="filterModal" direction="left" event="toggle_mobile_filter">--}}
{{--            <x-slot name="title">Фильтры</x-slot>--}}
{{--            <x-slot name="content">--}}
{{--                <livewire:cp-category-filter :category="$category" is-modal />--}}
{{--            </x-slot>--}}
{{--        </x-tt::modal.aside>--}}
{{--    @endpush--}}
</x-app-layout>
