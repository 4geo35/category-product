<div>
    @php($categoryModelClass = config("category-product.customCategoryModel") ?? \GIS\CategoryProduct\Models\Category::class)
    <div class="card">
        <div class="card-body">
            <div class="space-y-indent-half mb-indent">
                <div class="flex justify-between items-center">
                    @can("create", $categoryModelClass)
                        <button type="button" class="btn btn-primary" wire:click="showCreate">
                            <x-tt::ico.circle-plus />
                            <span class="pl-btn-ico-text">Добавить <span class="hidden sm:inline">корневую категорию</span></span>
                        </button>
                    @endcan
                    @can("order", $categoryModelClass)
                        @if ($tmpTree)
                            <button type="button" class="btn btn-outline-primary" wire:click="updateOrder">
                                Сохранить порядок
                            </button>
                        @endif
                    @endcan
                </div>
                <x-tt::notifications.error />
                <x-tt::notifications.success />
            </div>
            <div class="overflow-x-auto beautify-scrollbar" drag-category-root>
                @include("tt::admin.draggable-tree", ["tree" => $tree])
            </div>
        </div>
    </div>
    @include("cp::admin.categories.includes.modals")
</div>
