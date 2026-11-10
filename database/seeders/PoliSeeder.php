<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $polis = [
            ['nama_poli' => 'Poli Umum',       'keterangan' => 'Layanan pemeriksaan umum untuk semua keluhan'],
            ['nama_poli' => 'Poli Gigi',        'keterangan' => 'Layanan perawatan gigi dan mulut'],
            ['nama_poli' => 'Poli Anak',        'keterangan' => 'Layanan kesehatan khusus anak-anak'],
            ['nama_poli' => 'Poli Kandungan',   'keterangan' => 'Layanan kesehatan ibu dan kandungan'],
            ['nama_poli' => 'Poli Jantung',     'keterangan' => 'Layanan kesehatan kardiovaskular'],
        ];

        foreach ($polis as $poli) {
            Poli::updateOrCreate(['nama_poli' => $poli['nama_poli']], $poli);
        }
    }
}

