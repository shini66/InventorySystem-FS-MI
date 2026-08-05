<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Panel de control
        </h2>
    </x-slot>

    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="p-6 sm:p-8">
                    <p class="text-sm text-gray-500">Productos totales</p>
                    <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                </div>
            </div>
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="p-6 sm:p-8">
                    <p class="text-sm text-gray-500">Stock total</p>
                    <p class="text-3xl font-bold">{{ $totalStock }}</p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="p-6 sm:p-8">
                <p class="mb-3 font-semibold text-gray-900">Stock por categoría</p>
                @foreach ($byCategory as $row)
                    <div class="flex justify-between border-b border-gray-100 py-2 text-sm last:border-b-0">
                        <span>{{ $row->category }}</span><span>{{ $row->total }}</span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
