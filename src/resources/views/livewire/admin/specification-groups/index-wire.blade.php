<div class="card">
    <div class="card-body">
        <div class="space-y-indent-half">
            @include("cp::admin.specification-groups.includes.search")
            <x-tt::notifications.error />
            <x-tt::notifications.success />
        </div>
    </div>
    @include("cp::admin.specification-groups.includes.table")
    @include("cp::admin.specification-groups.includes.table-modals")
</div>

@include("tt::admin.draggable-script")
