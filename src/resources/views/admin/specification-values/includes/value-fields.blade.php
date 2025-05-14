<div>
    <label for="sValue" class="inline-block mb-2">
        {{ $type === "color" ? "Наименование цвета" : "Значение" }}<span class="text-danger">*</span>
    </label>
    <input type="text" id="sValue"
           class="form-control {{ $errors->has("value") ? "border-danger" : "" }}"
           required
           wire:loading.attr="disabled"
           wire:model.blur="value">
    <x-tt::form.error name="value"/>
</div>

@if ($type === "color")
    <div>
        <label for="colorValue" class="inline-block mb-2">
            Значение цвета<span class="text-danger">*</span>
        </label>
        <input type="text" id="colorValue" maxlength="7"
               class="form-control {{ $errors->has("colorValue") ? "border-danger" : "" }}"
               required
               @if ($disableColorHash) disabled @else wire:loading.attr="disabled" @endif
               wire:model.blur="colorValue">
        <x-tt::form.error name="colorValue"/>
        <div class="w-full h-3 rounded-base mt-1" style="background-color: {{ $colorValue }}"></div>
    </div>
@endif
