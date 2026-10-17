<x-layouts.app title="Pasien Dashboard">
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Halo, Selamat Datang Pasien</h1>
        <p class="mt-2 text-base-content/70">Selamat datang, {{ auth()->user()->nama }}.</p>
    </div>

    <div class="card bg-base-100 shadow-sm">
        <div class="card-body">
            <h2 class="card-title">Layanan Pasien</h2>
            <p>Daftarkan diri ke poli dan lihat nomor antrean kamu.</p>
            <div class="card-actions">
                <a href="{{ route('pasien.daftar-poli.index') }}" class="btn btn-primary">Daftar Poli</a>
            </div>
        </div>
    </div>
</x-layouts.app>
