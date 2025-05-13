<x-app-layout>
    @include("cp::web.catalog.includes.catalog-metas")
    @include("cp::web.catalog.includes.catalog-breadcrumbs")
    @include("cp::web.catalog.includes.catalog-h1")

    <div class="container">
        <div class="row">
            @foreach($categories as $item)
                <div class="col w-1/2 lg:w-1/4 mb-indent">
                    <x-cp::category.teaser :category="$item" />
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
