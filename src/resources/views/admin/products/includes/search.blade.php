<div class="flex justify-between mb-indent-half">
    <div class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
        <input type="text" aria-label="Заголовок" placeholder="Заголовок" class="form-control" wire:model.live="searchTitle">
        <select class="form-select" aria-label="Статус публикации" wire:model.live="searchPublished">
            <option value="all">Любая публикация</option>
            <option value="yes">Опубликовано</option>
            <option value="no">Снаято с публикации</option>
        </select>
        <button type="button" class="btn btn-outline-primary" wire:click="clearSearch">
            Очистить
        </button>
    </div>

    @if ($category)
        <div class="flex items-center space-x-2">
            @can("create", config("category-product.customProductModel") ?? \GIS\CategoryProduct\Models\Product::class)
                <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x ml-indent-half" wire:click="showCreate">
                    <x-tt::ico.circle-plus />
                    <span class="hidden lg:inline-block pl-btn-ico-text">Добавить</span>
                </button>
            @endcan
        </div>
    @endif
</div>
