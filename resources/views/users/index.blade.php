<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Usuarios</h2></x-slot>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 space-y-6">
        <x-alert />

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 p-6 sm:p-8 lg:flex-row lg:items-end lg:justify-between">
                <form method="GET" class="flex w-full flex-col gap-3 sm:max-w-2xl sm:flex-row">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar por nombre"
                           class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <x-secondary-button class="justify-center whitespace-nowrap">Filtrar</x-secondary-button>
                </form>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[52rem] w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Nombre</th>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Email</th>
                            <th class="border-b border-r border-gray-200 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Rol</th>
                            <th class="border-b border-gray-200 px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                    @foreach ($users as $user)
                        <tr class="transition hover:bg-indigo-50/50 even:bg-gray-50/50">
                            <td class="border-b border-r border-gray-200 px-4 py-3 font-medium text-gray-900">
                                {{ $user->name }}
                                @if ($user->is(auth()->user()))
                                    <span class="ms-2 text-xs text-gray-400">(tú)</span>
                                @endif
                            </td>
                            <td class="border-b border-r border-gray-200 px-4 py-3 text-gray-700">{{ $user->email }}</td>
                            <td class="border-b border-r border-gray-200 px-4 py-3">
                                <span class="inline-flex rounded-md px-2 py-0.5 text-xs font-medium {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="border-b border-gray-200 px-4 py-3 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('users.edit', $user) }}" class="font-medium text-blue-600 hover:text-blue-500">Editar</a>
                                    @if (! $user->is(auth()->user()))
                                        <form action="{{ route('users.update', $user) }}" method="POST" class="inline-flex items-center gap-2">
                                            @csrf @method('PATCH')
                                            <select name="role"
                                                    onchange="this.form.submit()"
                                                    class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="admin" @selected($user->role === 'admin')>admin</option>
                                                <option value="operator" @selected($user->role === 'operator')>operator</option>
                                            </select>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 flex justify-end">{{ $users->withQueryString()->links() }}</div>
    </div>
</x-app-layout>
