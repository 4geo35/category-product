<div class="container mt-indent"
     x-data="{ show: 'description' }"
     x-on:tab-description.window="show = 'description'"
     x-on:tab-specifications.window="show = 'specifications'">
    <div class="row my-indent-double py-indent border-y border-stroke">
        <div class="col w-full lg:w-1/4 mb-indent">
            <x-tt::tabs class="flex justify-start items-center lg:block space-x-indent-half lg:space-x-0 lg:space-y-indent-half">
                <x-tt::tabs.item name="description" active="btn-primary" passive="btn-outline-primary"
                                 class="w-full btn cursor-pointer">
                    Описание
                </x-tt::tabs.item>
                <x-tt::tabs.item name="specifications" active="btn-primary" passive="btn-outline-primary"
                                 class="w-full btn cursor-pointer">
                    Характеристики
                </x-tt::tabs.item>
            </x-tt::tabs>
        </div>
        <div class="col w-full lg:w-7/12 mx-auto">
            @include("cp::web.catalog.includes.product.description")
            @include("cp::web.catalog.includes.product.specification")
        </div>
    </div>
</div>
