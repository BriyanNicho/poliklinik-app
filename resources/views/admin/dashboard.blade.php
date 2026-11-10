<x-layouts.app title="Admin Dashboard">
    <div class="mb-8">
        <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-primary">Ringkasan sistem</p>
        <h1 class="text-3xl font-bold tracking-tight">Halo, {{ auth()->user()->nama }}</h1>
        <p class="mt-2 text-base-content/60">Kelola data dan layanan aplikasi poliklinik dari satu tempat.</p>
    </div>

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex size-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                <i class="fas fa-shield-heart text-xl"></i>
            </div>
            <h2 class="card-title mt-2">Panel administrasi siap digunakan</h2>
            <p class="text-base-content/60">Gunakan menu di samping untuk mengelola poli, dokter, pasien, dan obat.</p>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => 'Poli aktif', 'value' => $totalPoli, 'icon' => 'fa-hospital', 'color' => 'text-primary', 'bg' => 'bg-primary/10'],
            ['label' => 'Dokter', 'value' => $totalDokter, 'icon' => 'fa-user-doctor', 'color' => 'text-secondary', 'bg' => 'bg-secondary/10'],
            ['label' => 'Pasien', 'value' => $totalPasien, 'icon' => 'fa-users', 'color' => 'text-accent', 'bg' => 'bg-accent/10'],
            ['label' => 'Obat tersedia', 'value' => $totalObat, 'icon' => 'fa-pills', 'color' => 'text-warning', 'bg' => 'bg-warning/10'],
        ] as $stat)
            <div class="card bg-base-100">
                <div class="card-body flex-row items-center gap-4 p-5">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-2xl {{ $stat['bg'] }} {{ $stat['color'] }}">
                        <i class="fas {{ $stat['icon'] }} text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-base-content/60">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold">{{ $stat['value'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-2">
        <div class="card bg-base-100">
            <div class="card-body">
                <h2 class="card-title">Aktivitas layanan</h2>
                <div class="mt-2 grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-base-200/60 p-4">
                        <p class="text-sm text-base-content/60">Pendaftaran</p>
                        <p class="mt-1 text-xl font-bold">{{ $totalPendaftaran }}</p>
                    </div>
                    <div class="rounded-xl bg-base-200/60 p-4">
                        <p class="text-sm text-base-content/60">Pemeriksaan selesai</p>
                        <p class="mt-1 text-xl font-bold">{{ $totalPemeriksaan }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-primary text-primary-content">
            <div class="card-body">
                <h2 class="card-title">Akses cepat</h2>
                <p class="text-primary-content/80">Kelola data utama klinik dari menu yang tersedia.</p>
                <div class="card-actions mt-2 flex-wrap">
                    <a href="{{ route('dokter.index') }}" class="btn btn-sm border-0 bg-white/15 text-white hover:bg-white/25">Kelola dokter</a>
                    <a href="{{ route('pasien.index') }}" class="btn btn-sm border-0 bg-white/15 text-white hover:bg-white/25">Kelola pasien</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
