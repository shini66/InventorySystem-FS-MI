<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Historial de movimientos</h2></x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6">
        <x-alert />

        <div class="flex justify-between mb-4">
            <form method="GET">
                <select name="type" onchange="this.form.submit()" class="rounded-md border-gray-300 text-sm">
                    <option value="">Todos</option>
                    <option value="entrada" {{ request('type')==='entrada' ? 'selected' : '' }}>Entradas</option>
                    <option value="salida" {{ request('type')==='salida' ? 'selected' : '' }}>Salidas</option>
                </select>
            </form>
            <a href="{{ route('movements.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">+ Nuevo movimiento</a>
        </div>

        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="p-3">Fecha</th><th class="p-3">Producto</th>
                        <th class="p-3">Tipo</th><th class="p-3">Cantidad</th><th class="p-3">Detalle</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($movements as $m)
                    <tr class="border-t">
                        <td class="p-3">{{ $m->date->format('d/m/Y') }}</td>
                        <td class="p-3">{{ $m->product->name }}</td>
                        <td class="p-3">
                            <span class="{{ $m->type === 'entrada' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($m->type) }}
                            </span>
                        </td>
                        <td class="p-3">{{ $m->quantity }}</td>
                        <td class="p-3 text-gray-500">{{ $m->supplier ?? $m->reason ?? '—' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $movements->links() }}</div>
    </div>
</x-app-layout>
