<?php

namespace Database\Seeders;

use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DaftarPoliSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua pasien (selain admin & dokter)
        $pasiens     = User::where('role', 'pasien')->get()->keyBy('email');
        $dokterDemo  = User::where('email', 'dokter@gmail.com')->first();
        $budi        = User::where('email', 'budi.santoso@poliklinik.com')->first();
        $siti        = User::where('email', 'siti.rahayu@poliklinik.com')->first();
        $ahmad       = User::where('email', 'ahmad.fauzi@poliklinik.com')->first();

        // Ambil jadwal
        $jadwalDokterDemoSenin  = JadwalPeriksa::where('id_dokter', $dokterDemo?->id)->where('hari', 'Senin')->first();
        $jadwalDokterDemoKamis  = JadwalPeriksa::where('id_dokter', $dokterDemo?->id)->where('hari', 'Kamis')->first();
        $jadwalBudiSenin        = JadwalPeriksa::where('id_dokter', $budi?->id)->where('hari', 'Senin')->first();
        $jadwalBudiRabu         = JadwalPeriksa::where('id_dokter', $budi?->id)->where('hari', 'Rabu')->first();
        $jadwalSitiSelasa       = JadwalPeriksa::where('id_dokter', $siti?->id)->where('hari', 'Selasa')->first();
        $jadwalAhmadSenin       = JadwalPeriksa::where('id_dokter', $ahmad?->id)->where('hari', 'Senin')->first();

        // Obat
        $paracetamol  = Obat::where('nama_obat', 'Paracetamol 500mg')->first();
        $amoxicillin  = Obat::where('nama_obat', 'Amoxicillin 500mg')->first();
        $ibuprofen    = Obat::where('nama_obat', 'Ibuprofen 400mg')->first();
        $vitaminC     = Obat::where('nama_obat', 'Vitamin C 500mg')->first();
        $cetirizine   = Obat::where('nama_obat', 'Cetirizine 10mg')->first();
        $obhCombi     = Obat::where('nama_obat', 'OBH Combi Batuk')->first();
        $omeprazole   = Obat::where('nama_obat', 'Omeprazole 20mg')->first();

        $rows = [
            // --- Pasien di jadwal dokter@gmail.com (Senin) ---
            [
                'pasien_email'  => 'andi.firmansyah@gmail.com',
                'jadwal'        => $jadwalDokterDemoSenin,
                'keluhan'       => 'Demam tinggi selama 3 hari, disertai sakit kepala dan lemas',
                'no_antrian'    => 1,
                'periksa' => [
                    'tgl_periksa'  => Carbon::now()->subDays(7)->setTimeFromTimeString('09:00'),
                    'catatan'      => 'Pasien mengalami demam viral. Anjurkan banyak minum air putih dan istirahat cukup.',
                    'obat_ids'     => [$paracetamol?->id, $vitaminC?->id],
                ],
            ],
            [
                'pasien_email'  => 'bela.puspita@gmail.com',
                'jadwal'        => $jadwalDokterDemoSenin,
                'keluhan'       => 'Batuk berdahak sudah 1 minggu dan hidung tersumbat',
                'no_antrian'    => 2,
                'periksa' => [
                    'tgl_periksa'  => Carbon::now()->subDays(7)->setTimeFromTimeString('09:30'),
                    'catatan'      => 'Pasien mengalami ISPA ringan. Resepkan obat batuk dan antihistamin.',
                    'obat_ids'     => [$cetirizine?->id, $obhCombi?->id],
                ],
            ],
            [
                'pasien_email'  => 'cahyo.nugroho@gmail.com',
                'jadwal'        => $jadwalDokterDemoSenin,
                'keluhan'       => 'Nyeri perut bagian atas setelah makan, mual-mual',
                'no_antrian'    => 3,
                'periksa' => null, // Belum diperiksa
            ],

            // --- Pasien di jadwal dokter@gmail.com (Kamis) ---
            [
                'pasien_email'  => 'dian.permata@gmail.com',
                'jadwal'        => $jadwalDokterDemoKamis,
                'keluhan'       => 'Sakit gigi sebelah kiri bagian bawah, bengkak',
                'no_antrian'    => 1,
                'periksa'       => null,
            ],
            [
                'pasien_email'  => 'eko.prasetyo@gmail.com',
                'jadwal'        => $jadwalDokterDemoKamis,
                'keluhan'       => 'Gatal-gatal di lengan dan punggung sejak kemarin',
                'no_antrian'    => 2,
                'periksa'       => null,
            ],

            // --- Pasien di jadwal dr. Budi (Senin - Poli Umum) ---
            [
                'pasien_email'  => 'fitri.handayani@gmail.com',
                'jadwal'        => $jadwalBudiSenin,
                'keluhan'       => 'Pusing berputar saat bangun tidur, mual tapi tidak muntah',
                'no_antrian'    => 1,
                'periksa' => [
                    'tgl_periksa'  => Carbon::now()->subDays(14)->setTimeFromTimeString('08:30'),
                    'catatan'      => 'Pasien kemungkinan mengalami vertigo. Resepkan Betahistine.',
                    'obat_ids'     => [Obat::where('nama_obat', 'Betahistine 6mg')->first()?->id],
                ],
            ],
            [
                'pasien_email'  => 'guntur.wibowo@gmail.com',
                'jadwal'        => $jadwalBudiRabu,
                'keluhan'       => 'Susah tidur, sering cemas dan jantung berdebar',
                'no_antrian'    => 1,
                'periksa'       => null,
            ],

            // --- Pasien di jadwal dr. Siti (Selasa - Poli Gigi) ---
            [
                'pasien_email'  => 'hana.maharani@gmail.com',
                'jadwal'        => $jadwalSitiSelasa,
                'keluhan'       => 'Gigi berlubang di bagian geraham kanan, terasa ngilu saat minum dingin',
                'no_antrian'    => 1,
                'periksa'       => null,
            ],

            // --- Pasien demo (pasien@gmail.com) di jadwal dokter demo ---
            [
                'pasien_email'  => 'pasien@gmail.com',
                'jadwal'        => $jadwalDokterDemoSenin,
                'keluhan'       => 'Flu dan demam ringan, hidung berair',
                'no_antrian'    => 4,
                'periksa' => [
                    'tgl_periksa'  => Carbon::now()->subDays(3)->setTimeFromTimeString('10:00'),
                    'catatan'      => 'Pasien flu biasa. Istirahat, banyak minum air hangat dan konsumsi obat sesuai anjuran.',
                    'obat_ids'     => [$paracetamol?->id, $obhCombi?->id, $vitaminC?->id],
                ],
            ],
        ];

        foreach ($rows as $row) {
            if (!$row['jadwal'] || !$row['pasien_email']) {
                continue;
            }

            $pasien = $pasiens[$row['pasien_email']] ?? null;
            if (!$pasien) {
                continue;
            }

            // Hindari duplikat per pasien per jadwal
            $daftarPoli = DaftarPoli::updateOrCreate(
                ['id_pasien' => $pasien->id, 'id_jadwal' => $row['jadwal']->id],
                [
                    'keluhan'    => $row['keluhan'],
                    'no_antrian' => $row['no_antrian'],
                ]
            );

            // Buat data periksa jika ada
            if (!empty($row['periksa'])) {
                $periksaData = $row['periksa'];
                $obatIds     = array_filter($periksaData['obat_ids'] ?? []);
                $totalHargaObat = Obat::whereIn('id', $obatIds)->sum('harga');
                $totalBiaya  = 150000 + $totalHargaObat;

                $periksa = Periksa::updateOrCreate(
                    ['id_daftar_poli' => $daftarPoli->id],
                    [
                        'tgl_periksa'  => $periksaData['tgl_periksa'],
                        'catatan'      => $periksaData['catatan'],
                        'biaya_periksa'=> $totalBiaya,
                    ]
                );

                // Sync detail periksa (obat)
                DetailPeriksa::where('id_periksa', $periksa->id)->delete();

                $now = now();
                foreach ($obatIds as $obatId) {
                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat'    => $obatId,
                    ]);
                }
            }
        }
    }
}
