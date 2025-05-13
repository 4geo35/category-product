@if ($children->count())
    <div class="flex items-center justify-start space-x-indent-half flex-nowrap overflow-x-auto beautify-scrollbar mb-indent">
        @foreach($children as $child)
            <a href="{{ route('web.category', ['category' => $child]) }}" class="btn btn-outline-dark">
                {{ $child->title }}
            </a>
        @endforeach
    </div>
@endif
