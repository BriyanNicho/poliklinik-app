<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $obats = [
            ['nama_obat' => 'Paracetamol 500mg',   'kemasan' => 'Strip 10 tablet',    'harga' => 8000],
            ['nama_obat' => 'Amoxicillin 500mg',   'kemasan' => 'Strip 10 kapsul',    'harga' => 25000],
            ['nama_obat' => 'Ibuprofen 400mg',     'kemasan' => 'Strip 10 tablet',    'harga' => 15000],
            ['nama_obat' => 'Antasida Doen',       'kemasan' => 'Botol 100 tablet',   'harga' => 20000],
            ['nama_obat' => 'Cetirizine 10mg',     'kemasan' => 'Strip 10 tablet',    'harga' => 18000],
            ['nama_obat' => 'OBH Combi Batuk',     'kemasan' => 'Botol 100 ml',       'harga' => 22000],
            ['nama_obat' => 'Ranitidine 150mg',    'kemasan' => 'Strip 10 tablet',    'harga' => 12000],
            ['nama_obat' => 'Dexamethasone 0.5mg', 'kemasan' => 'Strip 10 tablet',    'harga' => 5000],
            ['nama_obat' => 'Vitamin C 500mg',     'kemasan' => 'Strip 10 tablet',    'harga' => 10000],
            ['nama_obat' => 'Metronidazole 500mg', 'kemasan' => 'Strip 10 tablet',    'harga' => 20000],
            ['nama_obat' => 'Salbutamol 2mg',      'kemasan' => 'Strip 10 tablet',    'harga' => 15000],
            ['nama_obat' => 'Omeprazole 20mg',     'kemasan' => 'Strip 10 kapsul',    'harga' => 30000],
            ['nama_obat' => 'Loratadine 10mg',     'kemasan' => 'Strip 10 tablet',    'harga' => 16000],
            ['nama_obat' => 'Betahistine 6mg',     'kemasan' => 'Strip 10 tablet',    'harga' => 35000],
            ['nama_obat' => 'Simvastatin 10mg',    'kemasan' => 'Strip 10 tablet',    'harga' => 28000],
        ];

        foreach ($obats as $obat) {
            Obat::updateOrCreate(['nama_obat' => $obat['nama_obat']], $obat);
        }
    }
}

