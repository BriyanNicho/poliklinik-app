<?php

namespace Database\Seeders;

use App\Models\JadwalPeriksa;
use App\Models\User;
use Illuminate\Database\Seeder;

class JadwalPeriksaSeeder extends Seeder
{
    public function run(): void
    {
        $budi    = User::where('email', 'budi.santoso@poliklinik.com')->first();
        $siti    = User::where('email', 'siti.rahayu@poliklinik.com')->first();
        $ahmad   = User::where('email', 'ahmad.fauzi@poliklinik.com')->first();
        $dewi    = User::where('email', 'dewi.lestari@poliklinik.com')->first();
        $hendra  = User::where('email', 'hendra.wijaya@poliklinik.com')->first();
        $dokterDemo = User::where('email', 'dokter@gmail.com')->first();

        $jadwals = [
            // dr. Budi Santoso - Poli Umum
            ['id_dokter' => $budi?->id,    'hari' => 'Senin',   'jam_mulai' => '08:00', 'jam_selesai' => '12:00'],
            ['id_dokter' => $budi?->id,    'hari' => 'Rabu',    'jam_mulai' => '08:00', 'jam_selesai' => '12:00'],
            ['id_dokter' => $budi?->id,    'hari' => 'Jumat',   'jam_mulai' => '13:00', 'jam_selesai' => '17:00'],

            // dr. Siti Rahayu - Poli Gigi
            ['id_dokter' => $siti?->id,    'hari' => 'Selasa',  'jam_mulai' => '09:00', 'jam_selesai' => '13:00'],
            ['id_dokter' => $siti?->id,    'hari' => 'Kamis',   'jam_mulai' => '09:00', 'jam_selesai' => '13:00'],
            ['id_dokter' => $siti?->id,    'hari' => 'Sabtu',   'jam_mulai' => '08:00', 'jam_selesai' => '11:00'],

            // dr. Ahmad Fauzi - Poli Anak
            ['id_dokter' => $ahmad?->id,   'hari' => 'Senin',   'jam_mulai' => '13:00', 'jam_selesai' => '17:00'],
            ['id_dokter' => $ahmad?->id,   'hari' => 'Rabu',    'jam_mulai' => '13:00', 'jam_selesai' => '17:00'],

            // dr. Dewi Lestari - Poli Kandungan
            ['id_dokter' => $dewi?->id,    'hari' => 'Selasa',  'jam_mulai' => '08:00', 'jam_selesai' => '12:00'],
            ['id_dokter' => $dewi?->id,    'hari' => 'Jumat',   'jam_mulai' => '08:00', 'jam_selesai' => '12:00'],

            // dr. Hendra Wijaya - Poli Jantung
            ['id_dokter' => $hendra?->id,  'hari' => 'Kamis',   'jam_mulai' => '14:00', 'jam_selesai' => '17:00'],
            ['id_dokter' => $hendra?->id,  'hari' => 'Sabtu',   'jam_mulai' => '09:00', 'jam_selesai' => '12:00'],

            // Akun demo dokter@gmail.com
            ['id_dokter' => $dokterDemo?->id, 'hari' => 'Senin',  'jam_mulai' => '08:00', 'jam_selesai' => '14:00'],
            ['id_dokter' => $dokterDemo?->id, 'hari' => 'Kamis',  'jam_mulai' => '08:00', 'jam_selesai' => '14:00'],
        ];

        foreach ($jadwals as $jadwal) {
            if (!$jadwal['id_dokter']) {
                continue;
            }
            // Hindari duplikat jadwal dengan dokter + hari yang sama
            JadwalPeriksa::updateOrCreate(
                ['id_dokter' => $jadwal['id_dokter'], 'hari' => $jadwal['hari']],
                ['jam_mulai' => $jadwal['jam_mulai'], 'jam_selesai' => $jadwal['jam_selesai']]
            );
        }
    }
}
