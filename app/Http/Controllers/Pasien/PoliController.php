<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PoliController extends Controller
{
    public function index(): View
    {
        $user = request()->user();
        $polis = Poli::query()->orderBy('nama_poli')->get();
        $jadwals = JadwalPeriksa::query()
            ->with('dokter')
            ->whereHas('dokter', fn ($query) => $query->where('role', 'dokter'))
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();
        $pendaftaran = DaftarPoli::query()
            ->with('jadwal.dokter')
            ->where('id_pasien', $user->id)
            ->latest()
            ->get();

        return view('pasien.daftar', compact('user', 'polis', 'jadwals', 'pendaftaran'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_poli' => ['required', 'integer', 'exists:poli,id'],
            'id_jadwal' => ['required', 'integer', 'exists:jadwal_periksa,id'],
            'keluhan' => ['required', 'string'],
        ]);

        $registration = DB::transaction(function () use ($validated, $request): DaftarPoli {
            $jadwal = JadwalPeriksa::query()
                ->with('dokter')
                ->lockForUpdate()
                ->findOrFail($validated['id_jadwal']);

            abort_unless(
                (int) $jadwal->dokter->id_poli === (int) $validated['id_poli'],
                422,
                'Jadwal tersebut tidak tersedia untuk poli yang dipilih.'
            );

            $alreadyRegistered = DaftarPoli::query()
                ->where('id_pasien', $request->user()->id)
                ->where('id_jadwal', $jadwal->id)
                ->exists();

            abort_if($alreadyRegistered, 422, 'Kamu sudah terdaftar pada jadwal tersebut.');

            $nextQueueNumber = (int) DaftarPoli::query()
                ->where('id_jadwal', $jadwal->id)
                ->lockForUpdate()
                ->max('no_antrian') + 1;

            return DaftarPoli::create([
                'id_pasien' => $request->user()->id,
                'id_jadwal' => $jadwal->id,
                'keluhan' => $validated['keluhan'],
                'no_antrian' => $nextQueueNumber,
            ]);
        });

        return redirect()
            ->route('pasien.daftar-poli.index')
            ->with('message', "Berhasil mendaftar. Nomor antrean kamu {$registration->no_antrian}.");
    }

    public function destroy(DaftarPoli $daftarPoli): RedirectResponse
    {
        abort_unless($daftarPoli->id_pasien === request()->user()->id, 403);

        $daftarPoli->delete();

        return redirect()
            ->route('pasien.daftar-poli.index')
            ->with('message', 'Pendaftaran berhasil dibatalkan.');
    }

}
