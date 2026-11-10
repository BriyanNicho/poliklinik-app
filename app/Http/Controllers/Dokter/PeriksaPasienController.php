<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        $dokterId = Auth::id();

        $daftarPolis = DaftarPoli::with([
                'pasien',
                'jadwalPeriksa',
                'periksa.detailPeriksas.obat'
            ])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPolis'));
    }

    public function create($id)
    {
        $dokterId = Auth::id();

        $daftarPoli = DaftarPoli::with(['pasien', 'jadwalPeriksa'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->findOrFail($id);

        $obats = Obat::orderBy('nama_obat')->get();
        $periksa = Periksa::with('detailPeriksas.obat')->where('id_daftar_poli', $daftarPoli->id)->first();
        $selectedObats = $periksa ? $periksa->detailPeriksas->pluck('id_obat')->toArray() : [];

        return view('dokter.periksa-pasien.create', compact('daftarPoli', 'obats', 'periksa', 'selectedObats'));
    }

    public function edit($id)
    {
        return $this->create($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => ['required', 'integer', 'exists:daftar_poli,id'],
            'tgl_periksa' => ['required'],
            'catatan' => ['nullable', 'string'],
            'obat' => ['nullable', 'array'],
            'obat.*' => ['integer', 'exists:obat,id'],
        ]);

        $dokterId = Auth::id();

        $daftarPoli = DaftarPoli::whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
            $query->where('id_dokter', $dokterId);
        })->findOrFail($request->id_daftar_poli);

        $selectedObatIds = $request->input('obat', []);
        $biayaObat = 0;
        if (!empty($selectedObatIds)) {
            $biayaObat = Obat::whereIn('id', $selectedObatIds)->sum('harga');
        }

        // Biaya dasar pemeriksaan dokter Rp 150.000 + total harga obat
        $totalBiaya = 150000 + $biayaObat;
        $isUpdate = false;

        DB::transaction(function () use ($daftarPoli, $request, $totalBiaya, $selectedObatIds, &$isUpdate) {
            $periksa = Periksa::firstOrNew(['id_daftar_poli' => $daftarPoli->id]);
            $isUpdate = $periksa->exists;

            $periksa->tgl_periksa = $request->tgl_periksa;
            $periksa->catatan = $request->catatan;
            $periksa->biaya_periksa = $totalBiaya;
            $periksa->save();

            // Sync detail periksa (obat)
            DetailPeriksa::where('id_periksa', $periksa->id)->delete();

            if (!empty($selectedObatIds)) {
                $details = [];
                $now = now();
                foreach ($selectedObatIds as $obatId) {
                    $details[] = [
                        'id_periksa' => $periksa->id,
                        'id_obat' => (int) $obatId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                DetailPeriksa::insert($details);
            }
        });

        $message = $isUpdate
            ? 'Data pemeriksaan pasien berhasil diperbarui.'
            : 'Pemeriksaan pasien berhasil disimpan.';

        return redirect()->route('periksa-pasien.index')
            ->with('message', $message)
            ->with('type', 'success');
    }
}
