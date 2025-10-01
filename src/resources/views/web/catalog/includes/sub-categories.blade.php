@if ($children->count())
    <div class="flex items-center justify-start space-x-indent flex-nowrap overflow-x-auto beautify-scrollbar mb-indent">
        @foreach($children as $child)
            <a href="{{ route('web.category', ['category' => $child]) }}" class="btn btn-outline-primary">
                {{ $child->title }}
            </a>
        @endforeach
    </div>
@endif
