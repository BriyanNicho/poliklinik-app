<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        $pasiens = [
            [
                'nama'   => 'Andi Firmansyah',
                'email'  => 'andi.firmansyah@gmail.com',
                'no_ktp' => '3201011503950001',
                'no_hp'  => '081312345601',
                'alamat' => 'Jl. Kebun Raya No. 12, Jakarta',
                'no_rm'  => '261110-001',
            ],
            [
                'nama'   => 'Bela Puspita',
                'email'  => 'bela.puspita@gmail.com',
                'no_ktp' => '3201012809980002',
                'no_hp'  => '081312345602',
                'alamat' => 'Jl. Anggrek No. 7, Bogor',
                'no_rm'  => '261110-002',
            ],
            [
                'nama'   => 'Cahyo Nugroho',
                'email'  => 'cahyo.nugroho@gmail.com',
                'no_ktp' => '3201010202910003',
                'no_hp'  => '081312345603',
                'alamat' => 'Jl. Melati No. 3, Depok',
                'no_rm'  => '261110-003',
            ],
            [
                'nama'   => 'Dian Permata',
                'email'  => 'dian.permata@gmail.com',
                'no_ktp' => '3201010505930004',
                'no_hp'  => '081312345604',
                'alamat' => 'Jl. Mawar No. 25, Bekasi',
                'no_rm'  => '261110-004',
            ],
            [
                'nama'   => 'Eko Prasetyo',
                'email'  => 'eko.prasetyo@gmail.com',
                'no_ktp' => '3201011007800005',
                'no_hp'  => '081312345605',
                'alamat' => 'Jl. Mangga No. 18, Tangerang',
                'no_rm'  => '261110-005',
            ],
            [
                'nama'   => 'Fitri Handayani',
                'email'  => 'fitri.handayani@gmail.com',
                'no_ktp' => '3201012012890006',
                'no_hp'  => '081312345606',
                'alamat' => 'Jl. Durian No. 9, Bandung',
                'no_rm'  => '261110-006',
            ],
            [
                'nama'   => 'Guntur Wibowo',
                'email'  => 'guntur.wibowo@gmail.com',
                'no_ktp' => '3201010709850007',
                'no_hp'  => '081312345607',
                'alamat' => 'Jl. Flamboyan No. 4, Surabaya',
                'no_rm'  => '261110-007',
            ],
            [
                'nama'   => 'Hana Maharani',
                'email'  => 'hana.maharani@gmail.com',
                'no_ktp' => '3201012504970008',
                'no_hp'  => '081312345608',
                'alamat' => 'Jl. Cempaka No. 11, Yogyakarta',
                'no_rm'  => '261110-008',
            ],
            // Akun demo default pasien
            [
                'nama'   => 'Pasien',
                'email'  => 'pasien@gmail.com',
                'no_ktp' => null,
                'no_hp'  => null,
                'alamat' => null,
                'no_rm'  => '261110-000',
            ],
        ];

        foreach ($pasiens as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'nama'     => $data['nama'],
                    'password' => Hash::make('pasien'),
                    'role'     => 'pasien',
                    'no_ktp'   => $data['no_ktp'],
                    'no_hp'    => $data['no_hp'],
                    'alamat'   => $data['alamat'],
                    'no_rm'    => $data['no_rm'],
                ]
            );
        }
    }
}
