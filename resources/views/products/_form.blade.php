<div class="space-y-6">
<div>
    <x-input-label for="name" value="Nombre" />
    <x-text-input id="name" name="name" class="mt-1 block w-full"
        value="{{ old('name', $product->name ?? '') }}" required />
    <x-input-error :messages="$errors->get('name')" class="mt-1" />
</div>

<div>
    <x-input-label for="description" value="Descripción" />
    <textarea id="description" name="description" rows="3"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
        <x-input-label for="sku" value="SKU" />
        <x-text-input id="sku" name="sku" class="mt-1 block w-full"
            value="{{ old('sku', $product->sku ?? '') }}" required />
        <x-input-error :messages="$errors->get('sku')" class="mt-1" />
    </div>
    <div>
        <x-input-label for="category" value="Categoría" />
        <x-text-input id="category" name="category" class="mt-1 block w-full"
            value="{{ old('category', $product->category ?? '') }}" required />
        <x-input-error :messages="$errors->get('category')" class="mt-1" />
    </div>
</div>

@isset($product)
    <p class="rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-500">
        Stock actual: <strong>{{ $product->stock }}</strong> (se modifica desde Movimientos, no acá)
    </p>
@endisset
</div>
