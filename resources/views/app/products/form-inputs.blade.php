@php $editing = isset($product) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $product->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="inventory"
            label="Inventory"
            value="{{ old('inventory', ($editing ? $product->inventory : '')) }}"
            max="255"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
