<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,       // Admin
            PoliSeeder::class,       // Data poli
            DokterSeeder::class,     // Akun dokter + relasi poli
            PasienSeeder::class,     // Akun pasien
            ObatSeeder::class,       // Master data obat
            JadwalPeriksaSeeder::class, // Jadwal praktik dokter
            DaftarPoliSeeder::class, // Pendaftaran pasien + data periksa
        ]);
    }
}
