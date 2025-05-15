@if (config("category-product.useH1"))
    <div class="container">
        <x-tt::h1 class="mb-indent">{{ $product->title }}</x-tt::h1>
    </div>
@endif
