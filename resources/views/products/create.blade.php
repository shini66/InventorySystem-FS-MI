<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Nuevo producto</h2></x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <form method="POST" action="{{ route('products.store') }}">
                @csrf
                @include('products._form')

                <x-primary-button>Guardar</x-primary-button>
                <a href="{{ route('products.index') }}" class="ml-3 text-sm text-gray-500">Cancelar</a>
            </form>
        </div>
    </div>
</x-app-layout>
