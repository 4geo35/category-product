<div>
     <div class="card">
         <div class="card-body">
             <div class="space-y-indent-half">
                 @include("cp::admin.products.includes.search")
                 <x-tt::notifications.error prefix="product-" />
                 <x-tt::notifications.success prefix="product-" />
             </div>
         </div>
         @include("cp::admin.products.includes.table")
         @include("cp::admin.products.includes.table-modals")
     </div>
</div>
