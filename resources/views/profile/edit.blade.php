<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Perfil
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 space-y-6">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="max-w-xl space-y-6 p-6 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="max-w-xl space-y-6 p-6 sm:p-8">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="max-w-xl space-y-6 p-6 sm:p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
