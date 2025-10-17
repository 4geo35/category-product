<x-app-layout>
    @include("cp::web.catalog.includes.category.metas")
    @include("cp::web.catalog.includes.category.breadcrumbs")

    @includeIf("pv::web.variations.order-single-variation-modal")
    <div class="container">
        <div class="row">
            <div class="col hidden lg:block lg:w-1/3 xl:w-1/4">
                <livewire:cp-category-filter :category="$category" />
            </div>
            <div class="col w-full lg:w-2/3 xl:w-3/4">
                <x-tt::h1 class="mb-indent-half">{{ $category->title }}</x-tt::h1>
                @include("cp::web.catalog.includes.sub-categories")
                {{-- Этот компонент просто ставит куку через лару --}}
                <livewire:cp-product-view-cookie />
                <livewire:cp-product-list :category="$category" />
            </div>
        </div>
    </div>

    @push("modals")
        <x-tt::modal.aside id="filterModal" direction="left" event="toggle_mobile_filter">
            <x-slot name="title">Фильтры</x-slot>
            <x-slot name="content">
                <livewire:cp-category-filter :category="$category" is-modal />
            </x-slot>
        </x-tt::modal.aside>
    @endpush

    @include("cp::web.catalog.includes.filter-range-script")
</x-app-layout>
