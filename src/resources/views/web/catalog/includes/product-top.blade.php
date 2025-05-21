<div class="container">
    <div class="row">
        <div class="col w-full md:w-1/4">
            @foreach($images as $image)
                <div class="mb-indent-half">
                    <img src="{{ route('thumb-img', ['template' => 'col-4-square', 'filename' => $image->file_name]) }}" alt="">
                </div>
            @endforeach
        </div>

        <div class="col w-full md:w-3/4">
            <div>{{ $product->short }}</div>
            @includeIf("pv::web.variations.show")
        </div>
    </div>
</div>
