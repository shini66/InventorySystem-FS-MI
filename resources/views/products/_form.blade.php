<div class="mb-4">
    <x-input-label for="name" value="Nombre" />
    <x-text-input id="name" name="name" class="block w-full mt-1"
        value="{{ old('name', $product->name ?? '') }}" required />
    <x-input-error :messages="$errors->get('name')" class="mt-1" />
</div>

<div class="mb-4">
    <x-input-label for="description" value="Descripción" />
    <textarea id="description" name="description" rows="3"
        class="block w-full mt-1 border-gray-300 rounded-md">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <x-input-label for="sku" value="SKU" />
        <x-text-input id="sku" name="sku" class="block w-full mt-1"
            value="{{ old('sku', $product->sku ?? '') }}" required />
        <x-input-error :messages="$errors->get('sku')" class="mt-1" />
    </div>
    <div>
        <x-input-label for="category" value="Categoría" />
        <x-text-input id="category" name="category" class="block w-full mt-1"
            value="{{ old('category', $product->category ?? '') }}" required />
        <x-input-error :messages="$errors->get('category')" class="mt-1" />
    </div>
</div>

@isset($product)
    <p class="text-sm text-gray-500 mb-4">
        Stock actual: <strong>{{ $product->stock }}</strong> (se modifica desde Movimientos, no acá)
    </p>
@endisset
