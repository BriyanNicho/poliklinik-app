<x-layouts.app title="Periksa Pasien - Dokter Poliklinik">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Daftar Pasien Pemeriksaan</h1>
            <p class="text-sm text-base-content/70">Kelola dan lakukan pemeriksaan terhadap pasien yang terdaftar di poli Anda.</p>
        </div>
    </div>

    @if (session('message'))
        <div class="alert alert-success mb-6 shadow-sm">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-0 sm:p-6">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-base-200/50 text-base-content/70">
                            <th class="w-16 text-center">No</th>
                            <th class="w-24 text-center">No Antrian</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>Jadwal Praktik</th>
                            <th class="text-center">Status</th>
                            <th class="text-right">Biaya Periksa</th>
                            <th class="text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarPolis as $index => $item)
                            @php
                                $periksa = $item->periksa;
                                $isSudahDiperiksa = !is_null($periksa);
                            @endphp
                            <tr class="hover">
                                <td class="text-center font-medium">{{ $index + 1 }}</td>
                                <td class="text-center">
                                    <span class="badge badge-primary font-bold text-white">
                                        {{ $item->no_antrian }}
                                    </span>
                                </td>
                                <td>
                                    <div class="font-bold text-base-content">{{ $item->pasien->nama ?? '-' }}</div>
                                    <div class="text-xs text-base-content/60">No. RM: {{ $item->pasien->no_rm ?? '-' }}</div>
                                </td>
                                <td class="max-w-xs truncate text-base-content/80">
                                    {{ $item->keluhan }}
                                </td>
                                <td>
                                    <span class="text-sm font-medium text-base-content">
                                        {{ $item->jadwalPeriksa->hari ?? '-' }}
                                    </span>
                                    <span class="block text-xs text-base-content/60">
                                        {{ substr($item->jadwalPeriksa->jam_mulai ?? '', 0, 5) }} - {{ substr($item->jadwalPeriksa->jam_selesai ?? '', 0, 5) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if ($isSudahDiperiksa)
                                        <span class="badge badge-success badge-sm text-white font-medium gap-1">
                                            <i class="fas fa-check text-xs"></i> Sudah Diperiksa
                                        </span>
                                    @else
                                        <span class="badge badge-warning badge-sm text-white font-medium gap-1">
                                            <i class="fas fa-clock text-xs"></i> Belum Diperiksa
                                        </span>
                                    @endif
                                </td>
                                <td class="text-right font-medium">
                                    @if ($isSudahDiperiksa)
                                        <span class="text-primary font-semibold">
                                            Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-base-content/40">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($isSudahDiperiksa)
                                        <a href="{{ route('periksa-pasien.create', $item->id) }}"
                                           class="btn btn-warning btn-xs text-white gap-1">
                                            <i class="fas fa-pen-to-square"></i>
                                            Edit Periksa
                                        </a>
                                    @else
                                        <a href="{{ route('periksa-pasien.create', $item->id) }}"
                                           class="btn btn-primary btn-xs text-white gap-1">
                                            <i class="fas fa-stethoscope"></i>
                                            Periksa
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8 text-base-content/60">
                                    <i class="fas fa-clipboard-user text-3xl mb-2 block opacity-40"></i>
                                    Belum ada pasien yang terdaftar pada jadwal praktik Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>

