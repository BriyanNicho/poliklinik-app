<x-layouts.app title="Admin Dashboard">
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Halo, Selamat Datang Admin</h1>
        <p class="mt-2 text-base-content/70">Selamat datang, {{ auth()->user()->nama }}.</p>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <h2 class="card-title">Ringkasan Admin</h2>
            <p>Kelola data dan layanan aplikasi poliklinik dari halaman ini.</p>
        </div>
    </div>
</x-layouts.app>
