@php
    $noGroup = $specificationData["noGroup"];
    $groups = $specificationData["groups"]
@endphp
<x-tt::tabs.content name="specifications">
    <x-slot name="title">Характеристики</x-slot>

    <div class="flex flex-col gap-y-indent">
        @if (! empty($noGroup))
            @foreach($noGroup as $item)
                <x-cp::product.specification-value :value="$item" />
            @endforeach
        @endif
        @if (! empty($groups))
            @foreach($groups as $group)
                <x-tt::h4>{{ $group->title }}</x-tt::h4>
                <div class="space-y-indent-half">
                    @foreach($group->items as $item)
                        <x-cp::product.specification-value :value="$item" />
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</x-tt::tabs.content>
