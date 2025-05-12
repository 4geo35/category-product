<div class="card">
    <div class="card-header border-b-0 space-y-indent-half">
        <div class="flex justify-between items-center">
            <h2 class="font-medium text-2xl">Характеристики</h2>

            <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x ml-indent-half" wire:click="showCreate">
                <x-tt::ico.circle-plus />
                <span class="hidden lg:inline-block pl-btn-ico-text">Добавить</span>
            </button>
        </div>
        <x-tt::notifications.error />
        <x-tt::notifications.success />
    </div>
    @include("cp::admin.specification-values.includes.table")
    @include("cp::admin.specification-values.includes.table-modals")
</div>
