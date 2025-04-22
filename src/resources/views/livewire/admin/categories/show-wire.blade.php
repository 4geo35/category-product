<div>
     <div class="card">
         <div class="card-header">
             <div class="space-y-indent-half">
                 @include("cp::admin.categories.includes.show-title")
                 <x-tt::notifications.error />
                 <x-tt::notifications.success />
             </div>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
                     <div class="row">
                         <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                             <h3 class="font-semibold">Адресная строка</h3>
                         </div>
                         <div class="col w-full xs:w-3/5">{{ $category->slug }}</div>
                     </div>

                     <div class="row">
                         <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                             <h3 class="font-semibold">Дата создания</h3>
                         </div>
                         <div class="col w-full xs:w-3/5">{{ $category->created_human }}</div>
                     </div>

                     @if ($category->created_at !== $category->updated_at)
                         <div class="row">
                             <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                                 <h3 class="font-semibold">Дата обновления</h3>
                             </div>
                             <div class="col w-full xs:w-3/5">{{ $category->updated_human }}</div>
                         </div>
                     @endif

                     @if($category->image_id && $category->image)
                         <div class="row">
                             <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                                 <h3 class="font-semibold">Изображение</h3>
                             </div>
                             <div class="col w-full xs:w-3/5">
                                 <a href="{{ route('thumb-img', ['filename' => $category->image->filename, 'template' => 'original']) }}"
                                    class="text-primary hover:text-primary-hover" target="_blank">
                                     Просмотр
                                 </a>
                             </div>
                         </div>
                     @endif

                     @if($category->short)
                         <div class="row">
                             <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                                 <h3 class="font-semibold">Краткое описание</h3>
                             </div>
                             <div class="col w-full xs:w-3/5">{{ $category->short }}</div>
                         </div>
                     @endif
                 </div>

                 <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
                     @if($category->description)
                         <div>
                             <h3 class="font-semibold mb-indent-half">Описание</h3>
                             <div class="prose max-w-none">
                                 {!! $category->markdown !!}
                             </div>
                         </div>
                     @endif
                 </div>
             </div>
         </div>
     </div>

    @include("cp::admin.categories.includes.modals")
</div>
