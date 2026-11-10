<x-layouts.app title="Dokter Dashboard">
    <div class="mb-8">
        <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-primary">Ruang kerja dokter</p>
        <h1 class="text-3xl font-bold tracking-tight">Halo, {{ auth()->user()->nama }}</h1>
        <p class="mt-2 text-base-content/60">Atur jadwal praktik dan proses pemeriksaan pasien dengan mudah.</p>
    </div>

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex size-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                <i class="fas fa-stethoscope text-xl"></i>
            </div>
            <h2 class="card-title mt-2">Siap melayani pasien hari ini?</h2>
            <p class="text-base-content/60">Kelola jadwal dan pemeriksaan pasien dari menu di samping.</p>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => 'Jadwal praktik', 'value' => $totalJadwal, 'icon' => 'fa-calendar-days', 'color' => 'text-primary', 'bg' => 'bg-primary/10'],
            ['label' => 'Total pasien', 'value' => $totalPasien, 'icon' => 'fa-users', 'color' => 'text-secondary', 'bg' => 'bg-secondary/10'],
            ['label' => 'Menunggu diperiksa', 'value' => $totalMenunggu, 'icon' => 'fa-hourglass-half', 'color' => 'text-warning', 'bg' => 'bg-warning/10'],
            ['label' => 'Pemeriksaan selesai', 'value' => $totalSelesai, 'icon' => 'fa-circle-check', 'color' => 'text-success', 'bg' => 'bg-success/10'],
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

    <div class="card mt-6 bg-base-100">
        <div class="card-body">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="card-title">Pasien menunggu pemeriksaan</h2>
                    <p class="text-sm text-base-content/60">Prioritas pasien yang belum memiliki catatan pemeriksaan.</p>
                </div>
                <a href="{{ route('periksa-pasien.index') }}" class="btn btn-primary btn-sm">Lihat semua</a>
            </div>
            <div class="mt-4 divide-y divide-base-200">
                @forelse ($pasienMenunggu as $daftar)
                    <div class="flex items-center justify-between gap-4 py-3 first:pt-0 last:pb-0">
                        <div class="min-w-0">
                            <p class="truncate font-semibold">{{ $daftar->pasien->nama }}</p>
                            <p class="text-sm text-base-content/60">
                                Antrean #{{ $daftar->no_antrian }} · {{ $daftar->jadwalPeriksa->hari }}
                            </p>
                        </div>
                        <a href="{{ route('periksa-pasien.create', $daftar->id) }}" class="btn btn-outline btn-sm shrink-0">Periksa</a>
                    </div>
                @empty
                    <div class="py-6 text-center text-sm text-base-content/60">
                        <i class="fas fa-circle-check mb-2 block text-2xl text-success/60"></i>
                        Tidak ada pasien yang menunggu.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
