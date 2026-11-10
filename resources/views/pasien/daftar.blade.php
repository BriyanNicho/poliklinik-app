<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Poli - Poliklinik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="mx-auto max-w-5xl space-y-6 px-4 py-12">
        <section class="rounded-2xl bg-white p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Pendaftaran Poli</h1>
                    <p class="mt-1 text-slate-600">Halo, {{ $user->nama }}.</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Logout</button>
                </form>
            </div>

            @if (session('message'))
                <div class="mt-6 rounded-lg bg-green-50 p-4 text-sm text-green-700">
                    {{ session('message') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 rounded-lg bg-red-50 p-4 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('pasien.daftar-poli.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                @csrf

                {{-- Pilih Poli --}}
                <label class="text-sm font-medium">
                    Poli
                    <select id="select-poli" name="id_poli" required
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                        <option value="">Pilih poli</option>
                        @foreach ($polis as $poli)
                            <option value="{{ $poli->id }}" @selected(old('id_poli') == $poli->id)>
                                {{ $poli->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                </label>

                {{-- Pilih Jadwal (difilter oleh JS sesuai poli yang dipilih) --}}
                <label class="text-sm font-medium">
                    Jadwal Dokter
                    <select id="select-jadwal" name="id_jadwal" required
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
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

                <label class="text-sm font-medium md:col-span-2">
                    Keluhan
                    <textarea name="keluhan" required rows="4"
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('keluhan') }}</textarea>
                </label>

                <button class="rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700 md:col-span-2">
                    Daftar Poli
                </button>
            </form>
        </section>

        <section class="rounded-2xl bg-white p-8 shadow-sm">
            <h2 class="text-xl font-bold">Pendaftaran Saya</h2>
            <div class="mt-4 space-y-3">
                @forelse ($pendaftaran as $daftar)
                    <div class="flex items-center justify-between gap-4 rounded-lg border border-slate-200 p-4">
                        <div>
                            <p class="font-semibold">Nomor antrean: {{ $daftar->no_antrian }}</p>
                            <p class="text-sm text-slate-600">
                                {{ $daftar->jadwal->dokter->nama }} &mdash; {{ $daftar->jadwal->hari }}
                                ({{ substr($daftar->jadwal->jam_mulai, 0, 5) }} - {{ substr($daftar->jadwal->jam_selesai, 0, 5) }})
                            </p>
                            <p class="mt-1 text-sm text-slate-600">{{ $daftar->keluhan }}</p>
                        </div>
                        <form method="POST" action="{{ route('pasien.daftar-poli.destroy', $daftar) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm font-semibold text-red-600">Batalkan</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-slate-600">Belum ada pendaftaran.</p>
                @endforelse
            </div>
        </section>
    </main>

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
</body>
</html>
