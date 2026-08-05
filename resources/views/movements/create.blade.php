<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Registrar movimiento</h2></x-slot>

    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8" x-data="{ type: '{{ old('type', 'entry') }}' }">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <form method="POST" action="{{ route('movements.store') }}">
                @csrf

                <div class="space-y-6 p-6 sm:p-8">
                <div>
                    <x-input-label value="Tipo" />
                    <select name="type" x-model="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="entry">Entrada</option>
                        <option value="exit">Salida</option>
                    </select>
                </div>

                <div>
                    <x-input-label value="Producto" />
                    <select name="product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (stock: {{ $product->stock }})</option>
                    @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <x-input-label value="Cantidad" />
                        <x-text-input type="number" name="quantity" min="1" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label value="Fecha" />
                        <x-text-input type="date" name="date" class="mt-1 block w-full" required />
                    </div>
                </div>

                <div x-show="type === 'entry'">
                    <x-input-label value="Proveedor" />
                    <x-text-input name="supplier" class="mt-1 block w-full" />
                </div>

                <div x-show="type === 'exit'">
                    <x-input-label value="Motivo" />
                    <x-text-input name="reason" class="mt-1 block w-full" />
                </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>Registrar</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
