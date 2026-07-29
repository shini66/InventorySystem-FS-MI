<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Registrar movimiento</h2></x-slot>

    <div class="py-8 max-w-xl mx-auto sm:px-6" x-data="{ type: '{{ old('type', 'entrada') }}' }">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <form method="POST" action="{{ route('movements.store') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label value="Tipo" />
                    <select name="type" x-model="type" class="block w-full mt-1 rounded-md border-gray-300">
                        <option value="entry">Entrada</option>
                        <option value="exit">Salida</option>
                    </select>
                </div>

                <div class="mb-4">
                    <x-input-label value="Producto" />
                    <select name="product_id" class="block w-full mt-1 rounded-md border-gray-300">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (stock: {{ $product->stock }})</option>
                    @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input-label value="Cantidad" />
                        <x-text-input type="number" name="quantity" min="1" class="block w-full mt-1" required />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label value="Fecha" />
                        <x-text-input type="date" name="date" class="block w-full mt-1" required />
                    </div>
                </div>

                <div x-show="type === 'entrada'" class="mb-4">
                    <x-input-label value="Proveedor" />
                    <x-text-input name="supplier" class="block w-full mt-1" />
                </div>

                <div x-show="type === 'salida'" class="mb-4">
                    <x-input-label value="Motivo" />
                    <x-text-input name="reason" class="block w-full mt-1" />
                </div>

                <x-primary-button>Registrar</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
