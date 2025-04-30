<div>
    <div class="card">
        <div class="card-header">
            <div class="space-y-indent-half">
                @include("cp::admin.products.includes.show-title")
                <x-tt::notifications.error prefix="product-" />
                <x-tt::notifications.success prefix="product-" />
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
                    <div class="row">
                        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                            <h3 class="font-semibold">Категория</h3>
                        </div>
                        <div class="col w-full xs:w-3/5">
                            <div class="flex items-center">
                                <a href="{{ route('admin.categories.show', ['category' => $product->category]) }}"
                                   class="text-primary hover:text-primary-hover">
                                    {{ $product->category->title }}
                                </a>
                                @can("update", $product)
                                    <button type="button" class="text-info hover:text-info-hover ml-2 cursor-pointer" wire:click="showCategory">
                                        <x-tt::ico.edit />
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                            <h3 class="font-semibold">Дата создания</h3>
                        </div>
                        <div class="col w-full xs:w-3/5">{{ $product->created_human }}</div>
                    </div>

                    @if ($product->created_at !== $product->updated_at)
                        <div class="row">
                            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                                <h3 class="font-semibold">Дата обновления</h3>
                            </div>
                            <div class="col w-full xs:w-3/5">{{ $product->updated_human }}</div>
                        </div>
                    @endif
                </div>

                <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
                    <div class="row">
                        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                            <h3 class="font-semibold">Адресная строка</h3>
                        </div>
                        <div class="col w-full xs:w-3/5">{{ $product->slug }}</div>
                    </div>

                    @if($product->short)
                        <div class="row">
                            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                                <h3 class="font-semibold">Краткое описание</h3>
                            </div>
                            <div class="col w-full xs:w-3/5">{{ $product->short }}</div>
                        </div>
                    @endif
                </div>
            </div>
            @if($product->description)
                <div class="mt-indent-half">
                    <h3 class="font-semibold mb-indent-half">Описание</h3>
                    <div class="prose max-w-none">
                        {!! $product->markdown !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include("cp::admin.products.includes.table-modals")
    @include("cp::admin.products.includes.change-category-modal")
</div>
