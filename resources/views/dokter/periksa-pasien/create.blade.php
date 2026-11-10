<x-layouts.app title="{{ $periksa ? 'Edit Pemeriksaan' : 'Periksa Pasien' }} - Dokter Poliklinik">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">
                {{ $periksa ? 'Edit Pemeriksaan Pasien' : 'Form Pemeriksaan Pasien' }}
            </h1>
            <p class="text-sm text-base-content/70">
                Lakukan diagnosa, berikan catatan medis, dan resepkan obat untuk pasien.
            </p>
        </div>
        <div>
            <a href="{{ route('periksa-pasien.index') }}" class="btn btn-outline btn-sm gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-error mb-6 shadow-sm">
            <i class="fas fa-circle-exclamation"></i>
            <div>
                <span class="font-bold">Terjadi kesalahan pada data input:</span>
                <ul class="list-disc list-inside text-xs mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Kolom Kiri: Informasi Pasien & Ringkasan Biaya --}}
        <div class="space-y-6 lg:col-span-1">
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <div class="flex items-center justify-between pb-3 border-b border-base-200">
                        <h2 class="card-title text-base">Informasi Pasien</h2>
                        <span class="badge badge-primary font-bold text-white">
                            No. {{ $daftarPoli->no_antrian }}
                        </span>
                    </div>

                    <div class="mt-4 space-y-3 text-sm">
                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-base-content/60">Nama Pasien</span>
                            <span class="font-bold text-base text-base-content">{{ $daftarPoli->pasien->nama ?? '-' }}</span>
                        </div>

                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-base-content/60">No. Rekam Medis (RM)</span>
                            <span class="font-medium text-base-content">{{ $daftarPoli->pasien->no_rm ?? '-' }}</span>
                        </div>

                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-base-content/60">Jadwal Praktik</span>
                            <span class="font-medium text-base-content">
                                {{ $daftarPoli->jadwalPeriksa->hari ?? '-' }}
                                ({{ substr($daftarPoli->jadwalPeriksa->jam_mulai ?? '', 0, 5) }} - {{ substr($daftarPoli->jadwalPeriksa->jam_selesai ?? '', 0, 5) }})
                            </span>
                        </div>

                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-base-content/60">Keluhan Pasien</span>
                            <div class="mt-1 rounded-lg bg-base-200/60 p-3 text-base-content text-sm">
                                {{ $daftarPoli->keluhan ?: '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Rincian Biaya --}}
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h2 class="card-title text-base flex items-center gap-2">
                        <i class="fas fa-receipt text-primary"></i>
                        Rincian Biaya Pemeriksaan
                    </h2>

                    <div class="mt-3 space-y-2 text-sm">
                        <div class="flex justify-between items-center text-base-content/70">
                            <span>Jasa Pemeriksaan Dokter:</span>
                            <span class="font-medium text-base-content">Rp 150.000</span>
                        </div>
                        <div class="flex justify-between items-center text-base-content/70">
                            <span>Total Harga Obat:</span>
                            <span id="label-biaya-obat" class="font-medium text-base-content">Rp 0</span>
                        </div>
                        <div class="border-t border-base-200 pt-2 flex justify-between items-center font-bold text-base">
                            <span>Total Biaya:</span>
                            <span id="label-total-biaya" class="text-primary text-lg">Rp 150.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form Pemeriksaan --}}
        <div class="card bg-base-100 shadow-sm border border-base-200 lg:col-span-2">
            <div class="card-body">
                <h2 class="card-title text-base pb-3 border-b border-base-200">
                    <i class="fas fa-user-doctor text-primary"></i>
                    Input Hasil Pemeriksaan
                </h2>

                <form action="{{ route('periksa-pasien.store') }}" method="POST" class="mt-4 space-y-5">
                    @csrf
                    <input type="hidden" name="id_daftar_poli" value="{{ $daftarPoli->id }}">

                    {{-- Tanggal Periksa --}}
                    <div class="form-control">
                        <label class="label font-semibold text-sm text-base-content">
                            <span>Tanggal & Waktu Periksa <span class="text-error">*</span></span>
                        </label>
                        @php
                            $tglVal = old(
                                'tgl_periksa',
                                $periksa && $periksa->tgl_periksa
                                    ? \Carbon\Carbon::parse($periksa->tgl_periksa)->format('Y-m-d\TH:i')
                                    : now()->format('Y-m-d\TH:i')
                            );
                        @endphp
                        <input type="datetime-local"
                               name="tgl_periksa"
                               value="{{ $tglVal }}"
                               class="input input-bordered w-full focus:input-primary"
                               required />
                    </div>

                    {{-- Catatan / Diagnosa --}}
                    <div class="form-control">
                        <label class="label font-semibold text-sm text-base-content">
                            <span>Catatan Dokter / Diagnosa</span>
                        </label>
                        <textarea name="catatan"
                                  rows="4"
                                  placeholder="Tuliskan catatan hasil pemeriksaan atau resep anjuran untuk pasien..."
                                  class="textarea textarea-bordered w-full focus:textarea-primary">{{ old('catatan', $periksa->catatan ?? '') }}</textarea>
                    </div>

                    {{-- Pilihan Resep Obat --}}
                    <div class="form-control">
                        <label class="label font-semibold text-sm text-base-content flex justify-between">
                            <span>Resep Obat (Pilih satu atau lebih)</span>
                            <span class="text-xs font-normal text-base-content/60">Centang obat yang diresepkan</span>
                        </label>

                        <div class="rounded-lg border border-base-200 bg-base-200/20 p-3 max-h-72 overflow-y-auto space-y-2">
                            @forelse ($obats as $obat)
                                @php
                                    $isChecked = in_array($obat->id, old('obat', $selectedObats ?? []));
                                @endphp
                                <label class="flex items-center justify-between p-2 rounded-md hover:bg-base-200 cursor-pointer transition">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox"
                                               name="obat[]"
                                               value="{{ $obat->id }}"
                                               data-harga="{{ $obat->harga }}"
                                               class="checkbox checkbox-primary checkbox-sm obat-checkbox"
                                               {{ $isChecked ? 'checked' : '' }} />
                                        <div>
                                            <div class="font-semibold text-sm text-base-content">{{ $obat->nama_obat }}</div>
                                            <div class="text-xs text-base-content/60">{{ $obat->kemasan ?: 'Tanpa kemasan' }}</div>
                                        </div>
                                    </div>
                                    <div class="text-sm font-semibold text-primary">
                                        Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                    </div>
                                </label>
                            @empty
                                <div class="text-center py-4 text-xs text-base-content/60">
                                    Belum ada data obat tersedia di master obat.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-base-200">
                        <a href="{{ route('periksa-pasien.index') }}" class="btn btn-ghost btn-sm">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm text-white gap-2">
                            <i class="fas fa-save"></i>
                            {{ $periksa ? 'Simpan Perubahan' : 'Simpan Pemeriksaan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script Hitung Biaya Otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.obat-checkbox');
            const labelBiayaObat = document.getElementById('label-biaya-obat');
            const labelTotalBiaya = document.getElementById('label-total-biaya');
            const baseFee = 150000;

            function formatRupiah(number) {
                return 'Rp ' + number.toLocaleString('id-ID');
            }

            function hitungTotal() {
                let totalObat = 0;
                checkboxes.forEach(function (cb) {
                    if (cb.checked) {
                        const harga = parseInt(cb.getAttribute('data-harga') || 0, 10);
                        totalObat += harga;
                    }
                });

                labelBiayaObat.textContent = formatRupiah(totalObat);
                labelTotalBiaya.textContent = formatRupiah(baseFee + totalObat);
            }

            checkboxes.forEach(function (cb) {
                cb.addEventListener('change', hitungTotal);
            });

            // Hitung saat halaman selesai dimuat (untuk old input atau edit)
            hitungTotal();
        });
    </script>
</x-layouts.app>
