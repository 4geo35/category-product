<div class="container mt-indent"
     x-data="{ show: 'description' }"
     x-on:tab-description.window="show = 'description'"
     x-on:tab-specifications.window="show = 'specifications'">
    <div class="row">
        <div class="col w-full lg:w-1/4 mb-indent">
            <x-tt::tabs class="flex justify-start items-center lg:block space-x-indent-half lg:space-x-0">
                <x-tt::tabs.item name="description" class="w-full px-indent py-indent-half text-nowrap mb-2.5 cursor-pointer hover:bg-secondary/20">
                    Описание
                </x-tt::tabs.item>
                <x-tt::tabs.item name="specifications" class="w-full px-indent py-indent-half text-nowrap mb-2.5 cursor-pointer hover:bg-secondary/20">
                    Характеристики
                </x-tt::tabs.item>
            </x-tt::tabs>
        </div>
        <div class="col w-full lg:w-3/4">
            @include("cp::web.catalog.includes.product.description")
            @include("cp::web.catalog.includes.product.specification")
        </div>
    </div>
</div>
