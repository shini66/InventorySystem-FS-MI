<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Editar usuario</h2></x-slot>

    <div class="mx-auto max-w-2xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PATCH')

                <div class="space-y-6 p-6 sm:p-8">
                    <div>
                        <x-input-label for="name" value="Nombre" />
                        <x-text-input id="name" name="name" class="mt-1 block w-full"
                            value="{{ old('name', $user->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            value="{{ old('email', $user->email) }}" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Nueva contraseña (opcional)" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                            autocomplete="new-password" placeholder="Dejar vacío para no cambiarla" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Confirmar contraseña" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                            class="mt-1 block w-full" autocomplete="new-password" />
                    </div>

                    <div>
                        <x-input-label for="role" value="Rol" />
                        @if ($user->is(auth()->user()))
                            <x-text-input id="role" class="mt-1 block w-full bg-gray-100" value="{{ $user->role }}" disabled />
                            <p class="mt-2 text-sm text-gray-500">No puedes cambiar tu propio rol.</p>
                        @else
                            <select id="role" name="role"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="admin" @selected(old('role', $user->role) === 'admin')>admin</option>
                                <option value="operator" @selected(old('role', $user->role) === 'operator')>operator</option>
                            </select>
                        @endif
                        <x-input-error :messages="$errors->get('role')" class="mt-1" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>Actualizar</x-primary-button>
                        <a href="{{ route('users.index') }}" class="text-sm font-medium text-gray-500 transition hover:text-gray-900">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
