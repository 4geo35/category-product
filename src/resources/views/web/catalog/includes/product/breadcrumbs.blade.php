@if (config("category-product.useBreadcrumbs"))
    @php($homeUrl = \Illuminate\Support\Facades\Route::has("web.home") ? route("web.home") : "/")
    <x-tt::breadcrumbs>
        <x-tt::breadcrumbs.item :url="$homeUrl">Главная</x-tt::breadcrumbs.item>
        <x-tt::breadcrumbs.item :url="route('web.catalog')">{{ config('category-product.catalogPageTitle') }}</x-tt::breadcrumbs.item>
        @foreach($parents as $parent)
            <x-tt::breadcrumbs.item :url="route('web.category', ['category' => $parent->slug])">
                {{ $parent->title }}
            </x-tt::breadcrumbs.item>
        @endforeach
        <x-tt::breadcrumbs.item :url="route('web.category', ['category' => $product->category->slug])">
            {{ $product->category->title }}
        </x-tt::breadcrumbs.item>
        <x-tt::breadcrumbs.item>{{ $product->title }}</x-tt::breadcrumbs.item>
    </x-tt::breadcrumbs>
@endif
