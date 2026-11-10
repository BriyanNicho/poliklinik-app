<x-layouts.app title="Riwayat Pasien - Poliklinik">
    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Riwayat Pemeriksaan Pasien</h1>
            <p class="text-sm text-base-content/70">Daftar pasien yang pernah Anda periksa beserta detail pemeriksaannya.</p>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-0 sm:p-6">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-base-200/50 text-base-content/70">
                            <th class="w-16 text-center">ID</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>Tanggal Pemeriksaan</th>
                            <th>Biaya Pemeriksaan</th>
                            <th class="text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatPasien as $periksa)
                            <tr class="hover">
                                <td class="text-center font-medium">{{ $periksa->id }}</td>
                                <td class="font-semibold text-base-content">
                                    {{ $periksa->daftarPoli->pasien->nama ?? '-' }}
                                </td>
                                <td class="max-w-xs truncate" title="{{ $periksa->daftarPoli->keluhan ?? '-' }}">
                                    {{ $periksa->daftarPoli->keluhan ?? '-' }}
                                </td>
                                <td>
                                    {{ $periksa->tgl_periksa ? \Carbon\Carbon::parse($periksa->tgl_periksa)->translatedFormat('d F Y, H:i') : '-' }}
                                </td>
                                <td class="font-medium text-emerald-600">
                                    Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('riwayat-pasien.show', $periksa->id) }}"
                                       class="btn btn-info btn-xs text-white gap-1">
                                        <i class="fas fa-eye"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-base-content/60">
                                    <i class="fas fa-folder-open text-3xl mb-2 block opacity-40"></i>
                                    Belum ada data riwayat pemeriksaan pasien.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>

