<x-layouts.app title="Manajemen Poli - Admin Poliklinik">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Manajemen Poli</h1>
            <p class="text-sm text-base-content/70">Kelola daftar poli layanan kesehatan yang tersedia.</p>
        </div>
        <div>
            <a href="{{ route('polis.create') }}" class="btn btn-primary btn-sm gap-2 text-white">
                <i class="fas fa-plus"></i>
                Tambah Poli
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-6 shadow-sm">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-0 sm:p-6">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-base-200/50 text-base-content/70">
                            <th class="w-16 text-center">No</th>
                            <th>Nama Poli</th>
                            <th>Keterangan</th>
                            <th class="text-center w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($polis as $index => $poli)
                            <tr class="hover">
                                <td class="text-center font-medium">{{ $index + 1 }}</td>
                                <td class="font-semibold text-base-content">{{ $poli->nama_poli }}</td>
                                <td class="text-base-content/70">
                                    {{ $poli->keterangan ?: '-' }}
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('polis.edit', $poli->id) }}"
                                           class="btn btn-warning btn-xs text-white gap-1">
                                            <i class="fas fa-pen-to-square"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('polis.destroy', $poli->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus poli ini?')">
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
                                <td colspan="4" class="text-center py-8 text-base-content/60">
                                    <i class="fas fa-hospital text-3xl mb-2 block opacity-40"></i>
                                    Belum ada data poli. Silakan tambahkan data baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>

