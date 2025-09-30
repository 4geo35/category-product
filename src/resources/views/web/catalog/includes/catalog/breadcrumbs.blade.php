@if (config("category-product.useBreadcrumbs"))
    @php($homeUrl = \Illuminate\Support\Facades\Route::has("web.home") ? route("web.home") : "/")
    <x-tt::breadcrumbs>
        <x-tt::breadcrumbs.item :url="$homeUrl">Главная</x-tt::breadcrumbs.item>
        <x-tt::breadcrumbs.item>{{ config('category-product.catalogPageTitle') }}</x-tt::breadcrumbs.item>
    </x-tt::breadcrumbs>
@endif
