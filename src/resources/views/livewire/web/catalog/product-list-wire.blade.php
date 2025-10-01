<div x-data="{ gridView: '{{ $gridView }}' }"
     x-init="
        console.log('hello');
        $refs.listButton.classList.remove('text-primary', 'text-primary/25');
        $refs.cardButton.classList.remove('text-primary', 'text-primary/25');
        ">
    @include("cp::web.catalog.includes.product.controls")

    @if (! $products->count())
        <div>По вашему запросу ничего не найдено</div>
    @else
        @foreach($products as $item)
            @php($product = \GIS\CategoryProduct\Facades\ProductActions::getTeaserData($item->id))
            <x-cp::product.teaser :product="$product" />
        @endforeach
        <div class="flex justify-between">
            <div>Всего: {{ $products->total() }}</div>
            {{ $products->links("tt::pagination.live") }}
        </div>
    @endif
</div>
