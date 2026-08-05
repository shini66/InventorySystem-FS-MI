<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Productos</h2></x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-alert />

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
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

        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[48rem] w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">SKU</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Categoría</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Stock</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-4 py-3 text-gray-700">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $product->sku }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $product->category }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $product->stock }}</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('products.edit', $product) }}" class="font-medium text-blue-600 hover:text-blue-500">Editar</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline"
                                      onsubmit="return confirm('¿Eliminar producto?')">
                                    @csrf @method('DELETE')
                                    <button class="font-medium text-red-600 hover:text-red-500">Eliminar</button>
                                </form>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">{{ $products->withQueryString()->links() }}</div>
    </div>
</x-app-layout>
