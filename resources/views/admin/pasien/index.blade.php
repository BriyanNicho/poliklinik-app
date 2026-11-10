<x-layouts.app title="Manajemen Pasien - Admin Poliklinik">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Manajemen Pasien</h1>
            <p class="text-sm text-base-content/70">Kelola daftar data pasien yang terdaftar di poliklinik.</p>
        </div>
        <div>
            <a href="{{ route('pasien.create') }}" class="btn btn-primary btn-sm gap-2 text-white">
                <i class="fas fa-plus"></i>
                Tambah Pasien
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
                            <th class="w-12 text-center">No</th>
                            <th>Nama Pasien</th>
                            <th>Email</th>
                            <th>No KTP</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th class="text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pasiens as $index => $pasien)
                            <tr class="hover">
                                <td class="text-center font-medium">{{ $index + 1 }}</td>
                                <td class="font-semibold text-base-content">{{ $pasien->nama }}</td>
                                <td>{{ $pasien->email }}</td>
                                <td>{{ $pasien->no_ktp ?: '-' }}</td>
                                <td>{{ $pasien->no_hp ?: '-' }}</td>
                                <td class="max-w-xs truncate" title="{{ $pasien->alamat ?: '-' }}">
                                    {{ $pasien->alamat ?: '-' }}
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('pasien.edit', $pasien->id) }}"
                                           class="btn btn-warning btn-xs text-white gap-1">
                                            <i class="fas fa-pen-to-square"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien ini?')">
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
                                <td colspan="7" class="text-center py-8 text-base-content/60">
                                    <i class="fas fa-bed-pulse text-3xl mb-2 block opacity-40"></i>
                                    Belum ada data pasien yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>

