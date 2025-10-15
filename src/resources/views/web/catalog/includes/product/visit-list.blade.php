@if ($visitCollection->count())
    <div class="container mt-indent">
        <div class="row product-row card-style">
            @foreach($visitCollection as $item)
                @php($product = \GIS\CategoryProduct\Facades\ProductActions::getTeaserData($item->id))
                <div class="col w-full sm:w-1/2 md:w-1/3 xl:w-1/4 mb-indent {{ $loop->last ? 'md:hidden xl:block' : '' }}">
                    <x-cp::product.teaser :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
@endif
