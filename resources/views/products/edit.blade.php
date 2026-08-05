<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Editar producto</h2></x-slot>

    <div class="mx-auto max-w-2xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <form method="POST" action="{{ route('products.update', $product) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6 p-6 sm:p-8">
                    @include('products._form')

                    <div class="flex items-center gap-3">
                        <x-primary-button>Actualizar</x-primary-button>
                        <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-500 transition hover:text-gray-900">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
