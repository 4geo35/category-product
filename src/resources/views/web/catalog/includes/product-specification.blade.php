@php
    $noGroup = $specificationData["noGroup"];
    $groups = $specificationData["groups"]
@endphp
<x-tt::tabs.content name="specifications">
    <x-slot name="title">Характеристики</x-slot>

    <div class="space-y-indent-half">
        @if (! empty($noGroup))
            @foreach($noGroup as $item)
                <x-cp::product.specification-value :value="$item" />
            @endforeach
        @endif
        @if (! empty($groups))
            @foreach($groups as $group)
                <div class="space-y-indent-half">
                    <x-tt::h3>{{ $group->title }}</x-tt::h3>
                    @foreach($group->items as $item)
                        <x-cp::product.specification-value :value="$item" />
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</x-tt::tabs.content>
