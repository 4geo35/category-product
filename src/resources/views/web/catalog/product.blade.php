<x-app-layout>
    @include("cp::web.catalog.includes.product.metas")
    @include("cp::web.catalog.includes.product.breadcrumbs")
    @include("cp::web.catalog.includes.product.h1")

    @include("cp::web.catalog.includes.product.top")
    @include("cp::web.catalog.includes.product.tabs")

    @include("cp::web.catalog.includes.product.visit-list")

    @includeIf("pv::web.variations.order-single-variation-modal")
</x-app-layout>
