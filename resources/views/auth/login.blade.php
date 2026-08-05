<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Recuérdame</span>
            </label>
        </div>

        <div class="mt-6 space-y-4">
            <x-primary-button class="w-full justify-center">
                Iniciar sesión
            </x-primary-button>

            <div class="space-y-2 text-center text-sm">
                @if (Route::has('register'))
                    <div class="text-gray-600">
                        <span>¿No tienes cuenta?</span>
                        <a class="font-medium text-indigo-600 rounded-md hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" href="{{ route('register') }}">
                            Regístrate
                        </a>
                    </div>
                @endif

                @if (Route::has('password.request'))
                    <div>
                        <a class="text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </form>
</x-guest-layout>
