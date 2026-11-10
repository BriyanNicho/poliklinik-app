<x-layouts.app title="Edit Dokter - Admin Poliklinik">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Edit Data Dokter</h1>
            <p class="text-sm text-base-content/70">Perbarui data profil dokter: <strong>{{ $dokter->nama }}</strong></p>
        </div>
        <div>
            <a href="{{ route('dokter.index') }}" class="btn btn-outline btn-sm gap-2">
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

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-6">
            <form action="{{ route('dokter.update', $dokter->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    {{-- Nama Dokter --}}
                    <div class="form-control">
                        <label class="label" for="nama">
                            <span class="label-text font-semibold">Nama Dokter <span class="text-error">*</span></span>
                        </label>
                        <input type="text"
                               id="nama"
                               name="nama"
                               value="{{ old('nama', $dokter->nama) }}"
                               placeholder="Nama lengkap beserta gelar"
                               class="input input-bordered w-full @error('nama') input-error @enderror"
                               required>
                        @error('nama')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-control">
                        <label class="label" for="email">
                            <span class="label-text font-semibold">Alamat Email <span class="text-error">*</span></span>
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email', $dokter->email) }}"
                               placeholder="dokter@contoh.com"
                               class="input input-bordered w-full @error('email') input-error @enderror"
                               required>
                        @error('email')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    {{-- No KTP --}}
                    <div class="form-control">
                        <label class="label" for="no_ktp">
                            <span class="label-text font-semibold">Nomor KTP <span class="text-error">*</span></span>
                        </label>
                        <input type="text"
                               id="no_ktp"
                               name="no_ktp"
                               maxlength="16"
                               value="{{ old('no_ktp', $dokter->no_ktp) }}"
                               placeholder="16 digit nomor KTP"
                               class="input input-bordered w-full @error('no_ktp') input-error @enderror"
                               required>
                        @error('no_ktp')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div class="form-control">
                        <label class="label" for="no_hp">
                            <span class="label-text font-semibold">Nomor HP / WhatsApp <span class="text-error">*</span></span>
                        </label>
                        <input type="text"
                               id="no_hp"
                               name="no_hp"
                               maxlength="15"
                               value="{{ old('no_hp', $dokter->no_hp) }}"
                               placeholder="Contoh: 08123456789"
                               class="input input-bordered w-full @error('no_hp') input-error @enderror"
                               required>
                        @error('no_hp')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    {{-- Bidang Poli --}}
                    <div class="form-control">
                        <label class="label" for="id_poli">
                            <span class="label-text font-semibold">Bidang Poli <span class="text-error">*</span></span>
                        </label>
                        <select id="id_poli"
                                name="id_poli"
                                class="select select-bordered w-full @error('id_poli') select-error @enderror"
                                required>
                            <option value="">-- Pilih Bidang Poli --</option>
                            @foreach ($polis as $poli)
                                <option value="{{ $poli->id }}" @selected(old('id_poli', $dokter->id_poli) == $poli->id)>
                                    {{ $poli->nama_poli }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_poli')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-control">
                        <label class="label" for="password">
                            <span class="label-text font-semibold">Password</span>
                            <span class="label-text-alt text-base-content/60">Kosongkan jika tidak diubah</span>
                        </label>
                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="Minimal 6 karakter"
                               class="input input-bordered w-full @error('password') input-error @enderror">
                        @error('password')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="form-control">
                    <label class="label" for="alamat">
                        <span class="label-text font-semibold">Alamat Lengkap <span class="text-error">*</span></span>
                    </label>
                    <textarea id="alamat"
                              name="alamat"
                              rows="3"
                              placeholder="Masukkan alamat domisili dokter"
                              class="textarea textarea-bordered w-full @error('alamat') textarea-error @enderror"
                              required>{{ old('alamat', $dokter->alamat) }}</textarea>
                    @error('alamat')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-base-200">
                    <a href="{{ route('dokter.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary text-white gap-2">
                        <i class="fas fa-save"></i>
                        Perbarui Dokter
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

