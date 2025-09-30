<x-tt::tabs.content name="description">
    <x-slot name="title">Описание</x-slot>

    <div class="prose max-w-none">{!! \Illuminate\Support\Str::markdown($product->description) !!}</div>
</x-tt::tabs.content>
