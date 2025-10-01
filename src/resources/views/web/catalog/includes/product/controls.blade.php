<div class="mb-indent flex justify-between items-center">
    @include("cp::web.catalog.includes.sort-choosing")
    <button type="button" x-data @click="$dispatch('toggle_mobile_filter')"
            class="btn btn-outline-secondary sm:hidden">
        Фильтры
    </button>
</div>
