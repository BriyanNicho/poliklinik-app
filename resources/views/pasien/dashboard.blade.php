<x-layouts.app title="Pasien Dashboard">
    <div class="mb-8">
        <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-primary">Layanan kesehatan</p>
        <h1 class="text-3xl font-bold tracking-tight">Halo, {{ auth()->user()->nama }}</h1>
        <p class="mt-2 text-base-content/60">Akses pendaftaran poli dan pantau antrean pemeriksaan Anda.</p>
    </div>

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex size-12 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                <i class="fas fa-calendar-check text-xl"></i>
            </div>
            <h2 class="card-title mt-2">Daftar pemeriksaan</h2>
            <p class="text-base-content/60">Pilih poli dan jadwal dokter yang sesuai untuk mendapatkan nomor antrean.</p>
            <div class="card-actions">
                <a href="{{ route('pasien.daftar-poli.index') }}" class="btn btn-primary mt-2">Daftar Poli</a>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        @foreach ([
            ['label' => 'Total pendaftaran', 'value' => $totalPendaftaran, 'icon' => 'fa-clipboard-list', 'color' => 'text-primary', 'bg' => 'bg-primary/10'],
            ['label' => 'Menunggu pemeriksaan', 'value' => $totalMenunggu, 'icon' => 'fa-hourglass-half', 'color' => 'text-warning', 'bg' => 'bg-warning/10'],
            ['label' => 'Selesai diperiksa', 'value' => $totalSelesai, 'icon' => 'fa-circle-check', 'color' => 'text-success', 'bg' => 'bg-success/10'],
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
                    <h2 class="card-title">Pendaftaran terbaru</h2>
                    <p class="text-sm text-base-content/60">Pantau jadwal pemeriksaan Anda.</p>
                </div>
                <a href="{{ route('pasien.daftar-poli.index') }}" class="btn btn-primary btn-sm">Daftar poli</a>
            </div>
            <div class="mt-4 divide-y divide-base-200">
                @forelse ($pendaftaran as $daftar)
                    <div class="flex items-center justify-between gap-4 py-3 first:pt-0 last:pb-0">
                        <div class="min-w-0">
                            <p class="truncate font-semibold">{{ $daftar->jadwalPeriksa->dokter->nama }}</p>
                            <p class="text-sm text-base-content/60">
                                Antrean #{{ $daftar->no_antrian }} · {{ $daftar->jadwalPeriksa->hari }}
                            </p>
                        </div>
                        @if ($daftar->periksa)
                            <span class="badge badge-success badge-outline shrink-0">Selesai</span>
                        @else
                            <span class="badge badge-warning badge-outline shrink-0">Menunggu</span>
                        @endif
                    </div>
                @empty
                    <div class="py-6 text-center text-sm text-base-content/60">
                        <i class="fas fa-calendar-plus mb-2 block text-2xl opacity-40"></i>
                        Belum ada pendaftaran. Silakan pilih poli dan jadwal dokter.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
