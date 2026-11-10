<x-layouts.app title="Tambah Poli - Admin Poliklinik">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Tambah Poli Baru</h1>
            <p class="text-sm text-base-content/70">Masukkan data poli layanan kesehatan yang ingin ditambahkan.</p>
        </div>
        <div>
            <a href="{{ route('polis.index') }}" class="btn btn-outline btn-sm gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-error mb-6 shadow-sm">
            <i class="fas fa-circle-exclamation"></i>
            <div>
                <span class="font-bold">Terjadi kesalahan input:</span>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="card bg-base-100 shadow-sm border border-base-200 max-w-2xl">
        <div class="card-body p-6">
            <form action="{{ route('polis.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="form-control">
                    <label class="label" for="nama_poli">
                        <span class="label-text font-semibold">Nama Poli <span class="text-error">*</span></span>
                    </label>
                    <input type="text"
                           id="nama_poli"
                           name="nama_poli"
                           value="{{ old('nama_poli') }}"
                           placeholder="Contoh: Poli Umum, Poli Gigi"
                           class="input input-bordered w-full @error('nama_poli') input-error @enderror"
                           required>
                    @error('nama_poli')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label" for="keterangan">
                        <span class="label-text font-semibold">Keterangan</span>
                    </label>
                    <textarea id="keterangan"
                              name="keterangan"
                              rows="4"
                              placeholder="Masukkan keterangan poli (opsional)"
                              class="textarea textarea-bordered w-full @error('keterangan') textarea-error @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-base-200">
                    <a href="{{ route('polis.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary text-white gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Poli
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

