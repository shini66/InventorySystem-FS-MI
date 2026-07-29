<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Productos</h2></x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6">
        <x-alert />

        <div class="flex justify-between items-center mb-4">
            <form method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Buscar por nombre" class="rounded-md border-gray-300 text-sm">
                <input type="text" name="category" value="{{ request('category') }}"
                       placeholder="Categoría" class="rounded-md border-gray-300 text-sm">
                <x-secondary-button>Filtrar</x-secondary-button>
            </form>

            @if (auth()->user()->role === 'admin')
                <a href="{{ route('products.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">
                    + Nuevo producto
                </a>
            @endif
        </div>

        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">SKU</th>
                        <th class="p-3">Categoría</th>
                        <th class="p-3">Stock</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr class="border-t">
                        <td class="p-3">{{ $product->name }}</td>
                        <td class="p-3">{{ $product->sku }}</td>
                        <td class="p-3">{{ $product->category }}</td>
                        <td class="p-3 font-semibold">{{ $product->stock }}</td>
                        <td class="p-3 text-right space-x-2">
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('products.edit', $product) }}" class="text-blue-600">Editar</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Eliminar producto?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Eliminar</button>
                            </form>
                        @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $products->withQueryString()->links() }}</div>
    </div>
</x-app-layout>
