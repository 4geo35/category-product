<div class="mb-indent flex justify-between items-center">
    <button type="button" x-data @click="$dispatch('toggle_mobile_filter')"
            class="btn btn-outline-secondary lg:hidden">
        Фильтры
    </button>
    @include("cp::web.catalog.includes.sort-choosing")
</div>
