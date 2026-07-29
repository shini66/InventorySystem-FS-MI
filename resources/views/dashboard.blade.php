<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Título de la sección
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-5 shadow sm:rounded-lg">
                <p class="text-sm text-gray-500">Productos totales</p>
                <p class="text-3xl font-bold">{{ $totalProducts }}</p>
            </div>
            <div class="bg-white p-5 shadow sm:rounded-lg">
                <p class="text-sm text-gray-500">Stock total</p>
                <p class="text-3xl font-bold">{{ $totalStock }}</p>
            </div>
        </div>

        <div class="bg-white p-5 shadow sm:rounded-lg">
            <p class="font-semibold mb-3">Stock por categoría</p>
            @foreach ($byCategory as $row)
                <div class="flex justify-between text-sm py-1 border-b">
                    <span>{{ $row->category }}</span><span>{{ $row->total }}</span>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
