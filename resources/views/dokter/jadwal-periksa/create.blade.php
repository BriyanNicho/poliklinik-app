<x-layouts.app title="Tambah Jadwal Periksa - Dokter Poliklinik">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Tambah Jadwal Periksa</h1>
            <p class="text-sm text-base-content/70">Tentukan hari dan jam praktik pemeriksaan Anda.</p>
        </div>
        <div>
            <a href="{{ route('jadwal-periksa.index') }}" class="btn btn-outline btn-sm gap-2">
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
            <form action="{{ route('jadwal-periksa.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Hari --}}
                <div class="form-control">
                    <label class="label" for="hari">
                        <span class="label-text font-semibold">Hari Praktik <span class="text-error">*</span></span>
                    </label>
                    <select id="hari"
                            name="hari"
                            class="select select-bordered w-full @error('hari') select-error @enderror"
                            required>
                        <option value="">-- Pilih Hari Praktik --</option>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                            <option value="{{ $hari }}" @selected(old('hari') == $hari)>
                                {{ $hari }}
                            </option>
                        @endforeach
                    </select>
                    @error('hari')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    {{-- Jam Mulai --}}
                    <div class="form-control">
                        <label class="label" for="jam_mulai">
                            <span class="label-text font-semibold">Jam Mulai <span class="text-error">*</span></span>
                        </label>
                        <input type="time"
                               id="jam_mulai"
                               name="jam_mulai"
                               value="{{ old('jam_mulai') }}"
                               class="input input-bordered w-full @error('jam_mulai') input-error @enderror"
                               required>
                        @error('jam_mulai')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    {{-- Jam Selesai --}}
                    <div class="form-control">
                        <label class="label" for="jam_selesai">
                            <span class="label-text font-semibold">Jam Selesai <span class="text-error">*</span></span>
                        </label>
                        <input type="time"
                               id="jam_selesai"
                               name="jam_selesai"
                               value="{{ old('jam_selesai') }}"
                               class="input input-bordered w-full @error('jam_selesai') input-error @enderror"
                               required>
                        @error('jam_selesai')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-base-200">
                    <a href="{{ route('jadwal-periksa.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary text-white gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

