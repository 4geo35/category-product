@props(["product"])
<div class="mb-indent-half relative">
    @includeIf("pf::web.favorite.switcher")
    <h3>
        <a href="{{ route("web.product", ["product" => $product]) }}" class="hover:text-primary">
            {{ $product->title }}
        </a>
    </h3>
</div>
