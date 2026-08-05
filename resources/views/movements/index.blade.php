<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Historial de movimientos</h2></x-slot>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 space-y-6">
        <x-alert />

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 p-6 sm:p-8 lg:flex-row lg:items-end lg:justify-between">
                <form method="GET" class="w-full sm:max-w-xs">
                    <select name="type" onchange="this.form.submit()" class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos</option>
                        <option value="entry" {{ request('type')==='entry' ? 'selected' : '' }}>Entradas</option>
                        <option value="exit" {{ request('type')==='exit' ? 'selected' : '' }}>Salidas</option>
                    </select>
                </form>
                <a href="{{ route('movements.create') }}" class="inline-flex items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">+ Nuevo movimiento</a>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[48rem] w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Fecha</th>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Producto</th>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Tipo</th>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Cantidad</th>
                            <th class="border-b border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Detalle</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                    @foreach ($movements as $m)
                        <tr class="transition hover:bg-indigo-50/50 even:bg-gray-50/50">
                            <td class="border-b border-r border-gray-200 px-4 py-3 text-gray-700">{{ $m->date->format('d/m/Y') }}</td>
                            <td class="border-b border-r border-gray-200 px-4 py-3 font-medium text-gray-900">{{ $m->product->name }}</td>
                            <td class="border-b border-r border-gray-200 px-4 py-3">
                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold {{ $m->type === 'entry' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $m->type === 'entry' ? 'Entrada' : 'Salida' }}
                                </span>
                            </td>
                            <td class="border-b border-r border-gray-200 px-4 py-3">
                                <span class="font-semibold {{ $m->type === 'entry' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $m->type === 'entry' ? '+' : '−' }}{{ $m->quantity }}
                                </span>
                            </td>
                            <td class="border-b border-gray-200 px-4 py-3 text-gray-600">{{ $m->supplier ?? $m->reason ?? '—' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 flex justify-end">{{ $movements->links() }}</div>
    </div>
</x-app-layout>
