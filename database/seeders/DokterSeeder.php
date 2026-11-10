<?php

namespace Database\Seeders;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        $poliUmum     = Poli::where('nama_poli', 'Poli Umum')->first();
        $poliGigi     = Poli::where('nama_poli', 'Poli Gigi')->first();
        $poliAnak     = Poli::where('nama_poli', 'Poli Anak')->first();
        $poliKandungan= Poli::where('nama_poli', 'Poli Kandungan')->first();
        $poliJantung  = Poli::where('nama_poli', 'Poli Jantung')->first();

        $dokters = [
            [
                'nama'    => 'dr. Budi Santoso',
                'email'   => 'budi.santoso@poliklinik.com',
                'no_ktp'  => '3201010101850001',
                'no_hp'   => '081234567801',
                'alamat'  => 'Jl. Merdeka No. 10, Jakarta',
                'id_poli' => $poliUmum?->id,
            ],
            [
                'nama'    => 'dr. Siti Rahayu, Sp.G',
                'email'   => 'siti.rahayu@poliklinik.com',
                'no_ktp'  => '3201010101870002',
                'no_hp'   => '081234567802',
                'alamat'  => 'Jl. Pahlawan No. 5, Bandung',
                'id_poli' => $poliGigi?->id,
            ],
            [
                'nama'    => 'dr. Ahmad Fauzi, Sp.A',
                'email'   => 'ahmad.fauzi@poliklinik.com',
                'no_ktp'  => '3201010101900003',
                'no_hp'   => '081234567803',
                'alamat'  => 'Jl. Diponegoro No. 20, Surabaya',
                'id_poli' => $poliAnak?->id,
            ],
            [
                'nama'    => 'dr. Dewi Lestari, Sp.OG',
                'email'   => 'dewi.lestari@poliklinik.com',
                'no_ktp'  => '3201010101920004',
                'no_hp'   => '081234567804',
                'alamat'  => 'Jl. Sudirman No. 15, Yogyakarta',
                'id_poli' => $poliKandungan?->id,
            ],
            [
                'nama'    => 'dr. Hendra Wijaya, Sp.JP',
                'email'   => 'hendra.wijaya@poliklinik.com',
                'no_ktp'  => '3201010101880005',
                'no_hp'   => '081234567805',
                'alamat'  => 'Jl. Gatot Subroto No. 8, Semarang',
                'id_poli' => $poliJantung?->id,
            ],
            // Akun demo default dokter (update id_poli jika sudah ada)
            [
                'nama'    => 'Dokter',
                'email'   => 'dokter@gmail.com',
                'no_ktp'  => null,
                'no_hp'   => null,
                'alamat'  => null,
                'id_poli' => $poliUmum?->id,
            ],
        ];

        foreach ($dokters as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'nama'     => $data['nama'],
                    'password' => Hash::make('dokter'),
                    'role'     => 'dokter',
                    'no_ktp'   => $data['no_ktp'],
                    'no_hp'    => $data['no_hp'],
                    'alamat'   => $data['alamat'],
                    'id_poli'  => $data['id_poli'],
                ]
            );
        }
    }
}
