<x-layouts.app title="Jadwal Periksa - Dokter Poliklinik">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Jadwal Periksa Praktik</h1>
            <p class="text-sm text-base-content/70">Kelola jadwal hari dan jam praktik pemeriksaan Anda.</p>
        </div>
        <div>
            <a href="{{ route('jadwal-periksa.create') }}" class="btn btn-primary btn-sm gap-2 text-white">
                <i class="fas fa-plus"></i>
                Tambah Jadwal
            </a>
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
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Status</th>
                            <th class="text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwalPeriksas as $index => $jadwal)
                            <tr class="hover">
                                <td class="text-center font-medium">{{ $index + 1 }}</td>
                                <td class="font-semibold text-base-content">{{ $jadwal->hari }}</td>
                                <td>{{ substr($jadwal->jam_mulai, 0, 5) }}</td>
                                <td>{{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                                <td>
                                    <span class="badge badge-success badge-sm text-white font-medium">
                                        {{ $jadwal->status ?? 'Aktif' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('jadwal-periksa.edit', $jadwal->id) }}"
                                           class="btn btn-warning btn-xs text-white gap-1">
                                            <i class="fas fa-pen-to-square"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('jadwal-periksa.destroy', $jadwal->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal periksa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error btn-xs text-white gap-1">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-base-content/60">
                                    <i class="fas fa-calendar-xmark text-3xl mb-2 block opacity-40"></i>
                                    Belum ada jadwal periksa yang dibuat. Silakan tambahkan jadwal praktik Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>

