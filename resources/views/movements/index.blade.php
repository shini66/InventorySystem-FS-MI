<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Historial de movimientos</h2></x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-alert />

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
            <form method="GET">
                <select name="type" onchange="this.form.submit()" class="rounded-md border-gray-300 text-sm">
                    <option value="">Todos</option>
                    <option value="entrada" {{ request('type')==='entrada' ? 'selected' : '' }}>Entradas</option>
                    <option value="salida" {{ request('type')==='salida' ? 'selected' : '' }}>Salidas</option>
                </select>
            </form>
            <a href="{{ route('movements.create') }}" class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">+ Nuevo movimiento</a>
        </div>

        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[48rem] w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Producto</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tipo</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Cantidad</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Detalle</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($movements as $m)
                        <tr>
                            <td class="px-4 py-3 text-gray-700">{{ $m->date->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $m->product->name }}</td>
                            <td class="px-4 py-3">
                                <span class="font-medium {{ $m->type === 'entrada' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ucfirst($m->type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $m->quantity }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $m->supplier ?? $m->reason ?? '—' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">{{ $movements->links() }}</div>
    </div>
</x-app-layout>
