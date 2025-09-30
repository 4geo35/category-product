@if ($category->short)
    <div class="ml-indent relative self-end" x-data="{ hovered: false, show: false }" @mouseleave="hovered = false" @click.outside="show = false">
        <button type="button" @mouseover="hovered = true" @click="show = true"
                class="flex items-center justify-center size-[30px] pr-1 font-bold italic text-2xl text-white bg-[#E8E8E8] rounded-lg cursor-help">
            i
        </button>
        <div class="bg-[#F4F4F4] z-10 absolute right-4 top-4 min-w-[270px] px-indent py-indent-half rounded-base shadow-md"
             x-show="hovered || show" style="display: none">
            {{ $category->short }}
        </div>
    </div>
@endif
