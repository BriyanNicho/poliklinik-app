<x-layouts.app title="Pendaftaran Poli">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-2 text-sm font-semibold uppercase tracking-wide text-primary">Layanan pasien</p>
            <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">Pendaftaran Poli</h1>
            <p class="mt-2 text-sm text-base-content/60">Halo, {{ $user->nama }}. Pilih poli dan jadwal dokter yang tersedia.</p>
        </div>
    </div>

    @if (session('message'))
        <div class="alert alert-success mb-6 border-0 shadow-sm">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error mb-6 border-0 shadow-sm">
            <i class="fas fa-circle-exclamation"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_minmax(0,1.15fr)]">
        <section class="card bg-base-100">
            <div class="card-body">
                <h2 class="card-title">Buat pendaftaran</h2>
                <p class="text-sm text-base-content/60">Data keluhan akan membantu dokter menyiapkan pemeriksaan.</p>

                <form method="POST" action="{{ route('pasien.daftar-poli.store') }}" class="mt-4 grid gap-4">
                @csrf

                <label class="form-control text-sm font-medium">
                    <span class="label-text mb-2 font-semibold">Poli</span>
                    <select id="select-poli" name="id_poli" required
                            class="select select-bordered w-full">
                        <option value="">Pilih poli</option>
                        @foreach ($polis as $poli)
                            <option value="{{ $poli->id }}" @selected(old('id_poli') == $poli->id)>
                                {{ $poli->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control text-sm font-medium">
                    <span class="label-text mb-2 font-semibold">Jadwal Dokter</span>
                    <select id="select-jadwal" name="id_jadwal" required
                            class="select select-bordered w-full">
                        <option value="">-- Pilih poli dahulu --</option>
                        @foreach ($jadwals as $jadwal)
                            {{-- Setiap option menyimpan id_poli dokter sebagai data attribute --}}
                            <option value="{{ $jadwal->id }}"
                                    data-poli="{{ $jadwal->dokter->id_poli }}"
                                    @selected(old('id_jadwal') == $jadwal->id)
                                    style="display:none">
                                {{ $jadwal->dokter->nama }} &mdash; {{ $jadwal->hari }}
                                ({{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }})
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="form-control text-sm font-medium">
                    <span class="label-text mb-2 font-semibold">Keluhan</span>
                    <textarea name="keluhan" required rows="4"
                        class="textarea textarea-bordered w-full">{{ old('keluhan') }}</textarea>
                </label>

                <button class="btn btn-primary mt-2 w-full">
                    Daftar Poli
                </button>
                </form>
            </div>
        </section>

        <section class="card bg-base-100">
            <div class="card-body">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="card-title">Pendaftaran Saya</h2>
                    <p class="mt-1 text-sm text-base-content/60">Daftar antrean yang masih aktif.</p>
                </div>
                <span class="badge badge-primary badge-outline">{{ $pendaftaran->count() }} aktif</span>
            </div>
            <div class="mt-4 space-y-3">
                @forelse ($pendaftaran as $daftar)
                    <div class="flex flex-col gap-4 rounded-xl border border-base-200 bg-base-200/30 p-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-semibold">Nomor antrean <span class="text-primary">#{{ $daftar->no_antrian }}</span></p>
                            <p class="text-sm text-base-content/60">
                                {{ $daftar->jadwal->dokter->nama }} &mdash; {{ $daftar->jadwal->hari }}
                                ({{ substr($daftar->jadwal->jam_mulai, 0, 5) }} - {{ substr($daftar->jadwal->jam_selesai, 0, 5) }})
                            </p>
                            <p class="mt-1 text-sm text-base-content/60">{{ $daftar->keluhan }}</p>
                        </div>
                        <form method="POST" action="{{ route('pasien.daftar-poli.destroy', $daftar) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-error btn-outline btn-sm">Batalkan</button>
                        </form>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-base-300 p-8 text-center text-sm text-base-content/60">
                        <i class="fas fa-calendar-check mb-3 block text-2xl opacity-40"></i>
                        Belum ada pendaftaran aktif.
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    @push('scripts')
    <script>
        (function () {
            const selectPoli   = document.getElementById('select-poli');
            const selectJadwal = document.getElementById('select-jadwal');
            const allOptions   = Array.from(selectJadwal.querySelectorAll('option[data-poli]'));

            function filterJadwal(poliId) {
                // Reset dropdown jadwal
                selectJadwal.value = '';

                let hasVisible = false;

                allOptions.forEach(function (opt) {
                    const match = poliId && String(opt.dataset.poli) === String(poliId);
                    opt.style.display = match ? '' : 'none';
                    opt.disabled = !match;
                    if (match) hasVisible = true;
                });

                // Update placeholder teks
                const placeholder = selectJadwal.querySelector('option[value=""]');
                if (placeholder) {
                    placeholder.textContent = hasVisible
                        ? '-- Pilih jadwal dokter --'
                        : '-- Tidak ada jadwal untuk poli ini --';
                }
            }

            // Jalankan saat halaman load (untuk old input setelah validasi gagal)
            filterJadwal(selectPoli.value);

            selectPoli.addEventListener('change', function () {
                filterJadwal(this.value);
            });

            // Pastikan old value jadwal terpilih kembali setelah filter dijalankan
            @if (old('id_jadwal'))
                const oldJadwal = '{{ old('id_jadwal') }}';
                Array.from(selectJadwal.options).forEach(function (opt) {
                    if (opt.value === oldJadwal && !opt.disabled) {
                        opt.selected = true;
                    }
                });
            @endif
        })();
    </script>
    @endpush
</x-layouts.app>
