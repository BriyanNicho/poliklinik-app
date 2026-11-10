<x-layouts.app title="Tambah Obat - Admin Poliklinik">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Tambah Obat Baru</h1>
            <p class="text-sm text-base-content/70">Masukkan data obat baru beserta kemasan dan harga satuan.</p>
        </div>
        <div>
            <a href="{{ route('obat.index') }}" class="btn btn-outline btn-sm gap-2">
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
            <form action="{{ route('obat.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Nama Obat --}}
                <div class="form-control">
                    <label class="label" for="nama_obat">
                        <span class="label-text font-semibold">Nama Obat <span class="text-error">*</span></span>
                    </label>
                    <input type="text"
                           id="nama_obat"
                           name="nama_obat"
                           value="{{ old('nama_obat') }}"
                           placeholder="Contoh: Paracetamol 500mg, Amoxicillin"
                           class="input input-bordered w-full @error('nama_obat') input-error @enderror"
                           required>
                    @error('nama_obat')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- Kemasan --}}
                <div class="form-control">
                    <label class="label" for="kemasan">
                        <span class="label-text font-semibold">Kemasan <span class="text-error">*</span></span>
                    </label>
                    <input type="text"
                           id="kemasan"
                           name="kemasan"
                           value="{{ old('kemasan') }}"
                           placeholder="Contoh: Strip / 10 Tablet, Botol 60ml, Kapsul"
                           class="input input-bordered w-full @error('kemasan') input-error @enderror"
                           required>
                    @error('kemasan')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="form-control">
                    <label class="label" for="harga">
                        <span class="label-text font-semibold">Harga (Rp) <span class="text-error">*</span></span>
                    </label>
                    <input type="number"
                           id="harga"
                           name="harga"
                           min="0"
                           step="1"
                           value="{{ old('harga') }}"
                           placeholder="Contoh: 15000"
                           class="input input-bordered w-full @error('harga') input-error @enderror"
                           required>
                    @error('harga')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-base-200">
                    <a href="{{ route('obat.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary text-white gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Obat
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

