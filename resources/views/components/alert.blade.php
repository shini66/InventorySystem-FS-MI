@if (session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm">
        {{ session('success') }}
    </div>
@endif
