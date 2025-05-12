@switch($type)
    @case("color")
        <div>
            <label for="firstSplitValue" class="inline-block mb-2">
                Значение цвета<span class="text-danger">*</span>
            </label>
            <input type="text" id="firstSplitValue" maxlength="7"
                   class="form-control {{ $errors->has("firstSplitValue") ? "border-danger" : "" }}"
                   required
                   wire:loading.attr="disabled"
                   wire:model.blur="firstSplitValue">
            <x-tt::form.error name="firstSplitValue"/>
            <div class="w-full h-3 rounded-base mt-1" style="background-color: {{ $firstSplitValue }}"></div>
        </div>

        <div>
            <label for="secondSplitValue" class="inline-block mb-2">
                Наименование цвета<span class="text-danger">*</span>
            </label>
            <input type="text" id="secondSplitValue"
                   class="form-control {{ $errors->has("secondSplitValue") ? "border-danger" : "" }}"
                   required
                   wire:loading.attr="disabled"
                   wire:model="secondSplitValue">
            <x-tt::form.error name="secondSplitValue"/>
        </div>
        @break
    @default
        <div>
            <label for="sValue" class="inline-block mb-2">
                Значение<span class="text-danger">*</span>
            </label>
            <input type="text" id="sValue"
                   class="form-control {{ $errors->has("value") ? "border-danger" : "" }}"
                   required
                   wire:loading.attr="disabled"
                   wire:model="value">
            <x-tt::form.error name="value"/>
        </div>
@endswitch
