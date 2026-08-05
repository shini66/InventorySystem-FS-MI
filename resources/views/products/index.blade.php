<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Productos</h2></x-slot>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 space-y-6">
        <x-alert />

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 p-6 sm:p-8 lg:flex-row lg:items-end lg:justify-between">
                <form method="GET" class="flex w-full flex-col gap-3 sm:max-w-2xl sm:flex-row">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar por nombre"
                           class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <input type="text" name="category" value="{{ request('category') }}"
                           placeholder="Categoría"
                           class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <x-secondary-button class="justify-center whitespace-nowrap">Filtrar</x-secondary-button>
                </form>

                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                        + Nuevo producto
                    </a>
                @endif
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[52rem] w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nombre</th>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">SKU</th>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Categoría</th>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Stock</th>
                            <th class="border-b border-gray-200 px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                    @foreach ($products as $product)
                        <tr class="transition hover:bg-indigo-50/50 even:bg-gray-50/50">
                            <td class="border-b border-r border-gray-200 px-4 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="border-b border-r border-gray-200 px-4 py-3 text-gray-700">
                                <span class="inline-flex rounded-md bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $product->sku }}</span>
                            </td>
                            <td class="border-b border-r border-gray-200 px-4 py-3 text-gray-700">{{ $product->category }}</td>
                            <td class="border-b border-r border-gray-200 px-4 py-3">
                                <span class="font-semibold {{ $product->stock <= 0 ? 'text-red-600' : ($product->stock <= 10 ? 'text-amber-600' : 'text-gray-900') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="border-b border-gray-200 px-4 py-3 text-right whitespace-nowrap space-x-2">
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

        <div class="mt-6 flex justify-end">{{ $products->withQueryString()->links() }}</div>
    </div>
</x-app-layout>
