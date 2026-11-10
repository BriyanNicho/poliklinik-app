<x-layouts.app title="Detail Riwayat Pasien - Poliklinik">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Detail Riwayat Pemeriksaan</h1>
            <p class="text-sm text-base-content/70">Informasi lengkap hasil pemeriksaan pasien.</p>
        </div>
        <div>
            <a href="{{ route('riwayat-pasien.index') }}" class="btn btn-outline btn-sm gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Data Pasien & Kunjungan --}}
        <div class="card bg-base-100 shadow-sm border border-base-200 lg:col-span-1">
            <div class="card-body">
                <div class="flex items-center justify-between pb-3 border-b border-base-200">
                    <h2 class="card-title text-base">Informasi Pasien</h2>
                    <span class="badge badge-primary font-semibold">
                        No. Antrian: {{ $periksa->daftarPoli->no_antrian ?? '-' }}
                    </span>
                </div>

                <div class="mt-4 space-y-3 text-sm">
                    <div>
                        <span class="block text-xs font-semibold uppercase tracking-wider text-base-content/60">Nama Pasien</span>
                        <span class="font-bold text-base text-base-content">{{ $periksa->daftarPoli->pasien->nama ?? '-' }}</span>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold uppercase tracking-wider text-base-content/60">Poli</span>
                        <span class="font-medium text-base-content">{{ $periksa->daftarPoli->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</span>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold uppercase tracking-wider text-base-content/60">Dokter Pemeriksa</span>
                        <span class="font-medium text-base-content">{{ $periksa->daftarPoli->jadwalPeriksa->dokter->nama ?? '-' }}</span>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold uppercase tracking-wider text-base-content/60">Tanggal Periksa</span>
                        <span class="font-medium text-base-content">
                            {{ $periksa->tgl_periksa ? \Carbon\Carbon::parse($periksa->tgl_periksa)->translatedFormat('d F Y, H:i') : '-' }}
                        </span>
                    </div>

                    <div>
                        <span class="block text-xs font-semibold uppercase tracking-wider text-base-content/60">Keluhan Pasien</span>
                        <div class="mt-1 rounded-lg bg-base-200/60 p-3 text-base-content">
                            {{ $periksa->daftarPoli->keluhan ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Catatan Dokter & Obat yang Diresepkan --}}
        <div class="space-y-6 lg:col-span-2">
            {{-- Catatan Dokter --}}
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h2 class="card-title text-base flex items-center gap-2">
                        <i class="fas fa-stethoscope text-primary"></i>
                        Catatan Dokter / Diagnosa
                    </h2>
                    <div class="mt-2 rounded-lg bg-base-200/50 p-4 text-sm leading-relaxed text-base-content">
                        {{ $periksa->catatan ?: 'Tidak ada catatan dokter.' }}
                    </div>
                </div>
            </div>

            {{-- Obat yang Diresepkan --}}
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h2 class="card-title text-base flex items-center gap-2">
                        <i class="fas fa-pills text-secondary"></i>
                        Obat yang Diresepkan
                    </h2>

                    <div class="mt-3 overflow-x-auto">
                        <table class="table table-sm w-full">
                            <thead>
                                <tr class="bg-base-200/50 text-base-content/70">
                                    <th class="w-12 text-center">No</th>
                                    <th>Nama Obat</th>
                                    <th>Kemasan</th>
                                    <th class="text-right">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($periksa->detailPeriksas as $index => $detail)
                                    <tr>
                                        <td class="text-center font-medium">{{ $index + 1 }}</td>
                                        <td class="font-semibold text-base-content">{{ $detail->obat->nama_obat ?? '-' }}</td>
                                        <td class="text-base-content/70">{{ $detail->obat->kemasan ?? '-' }}</td>
                                        <td class="text-right font-medium">
                                            Rp {{ number_format($detail->obat->harga ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-base-content/60">
                                            Tidak ada obat yang diresepkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Total Biaya Periksa --}}
                    <div class="mt-4 flex items-center justify-between rounded-xl bg-primary/10 p-4 text-primary">
                        <span class="font-semibold text-sm">Total Biaya Periksa</span>
                        <span class="text-xl font-bold">
                            Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

