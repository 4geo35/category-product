@props(["product"])
<div class="mb-indent-half">
    <h3>
        <a href="{{ route("web.product", ["product" => $product]) }}" class="hover:text-primary">
            {{ $product->title }}
        </a>
    </h3>
</div>
