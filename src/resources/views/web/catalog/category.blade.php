<x-app-layout>
    @include("cp::web.catalog.includes.category-metas")
    @include("cp::web.catalog.includes.category-breadcrumbs")

    <div class="container">
        <div class="row">
            <div class="col w-1/4">
                Filters
            </div>
            <div class="col w-3/4">
                <x-tt::h1 class="mb-indent-half">{{ $category->title }}</x-tt::h1>
                @include("cp::web.catalog.includes.sub-categories")
            </div>
        </div>
    </div>
</x-app-layout>
