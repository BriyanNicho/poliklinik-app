<?php

namespace Tests\Feature;

use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeriksaPasienTest extends TestCase
{
    use RefreshDatabase;

    private User $dokter;
    private User $pasien;
    private Poli $poli;
    private JadwalPeriksa $jadwal;
    private DaftarPoli $daftarPoli;
    private Obat $obatA;
    private Obat $obatB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->poli = Poli::create([
            'nama_poli' => 'Poli Umum',
            'deskripsi' => 'Pemeriksaan umum',
        ]);

        $this->dokter = User::factory()->create([
            'role' => 'dokter',
            'id_poli' => $this->poli->id,
        ]);

        $this->pasien = User::factory()->create([
            'role' => 'pasien',
        ]);

        $this->jadwal = JadwalPeriksa::create([
            'id_dokter' => $this->dokter->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '12:00',
        ]);

        $this->daftarPoli = DaftarPoli::create([
            'id_pasien' => $this->pasien->id,
            'id_jadwal' => $this->jadwal->id,
            'keluhan' => 'Demam dan batuk pilek',
            'no_antrian' => 1,
        ]);

        $this->obatA = Obat::create([
            'nama_obat' => 'Paracetamol 500mg',
            'kemasan' => 'Strip 10 tablet',
            'harga' => 15000,
        ]);

        $this->obatB = Obat::create([
            'nama_obat' => 'Amoxicillin 500mg',
            'kemasan' => 'Strip 10 kaplet',
            'harga' => 25000,
        ]);
    }

    public function test_guest_cannot_access_periksa_pasien(): void
    {
        $response = $this->get(route('periksa-pasien.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_dokter_can_view_periksa_pasien_index(): void
    {
        $response = $this->actingAs($this->dokter)->get(route('periksa-pasien.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Pasien Pemeriksaan');
        $response->assertSee($this->pasien->nama);
        $response->assertSee('Demam dan batuk pilek');
        $response->assertSee('Belum Diperiksa');
    }

    public function test_dokter_can_view_create_form_for_patient(): void
    {
        $response = $this->actingAs($this->dokter)->get(route('periksa-pasien.create', $this->daftarPoli->id));

        $response->assertStatus(200);
        $response->assertSee('Form Pemeriksaan Pasien');
        $response->assertSee($this->pasien->nama);
        $response->assertSee('Paracetamol 500mg');
        $response->assertSee('Amoxicillin 500mg');
    }

    public function test_dokter_can_store_examination_and_prescribe_medicines(): void
    {
        $tglPeriksa = now()->format('Y-m-d H:i:s');

        $response = $this->actingAs($this->dokter)->post(route('periksa-pasien.store'), [
            'id_daftar_poli' => $this->daftarPoli->id,
            'tgl_periksa' => $tglPeriksa,
            'catatan' => 'Pasien flu biasa, istirahat dan minum obat teratur.',
            'obat' => [$this->obatA->id, $this->obatB->id],
        ]);

        $response->assertRedirect(route('periksa-pasien.index'));
        $response->assertSessionHas('message', 'Pemeriksaan pasien berhasil disimpan.');

        // Total biaya: 150.000 + 15.000 + 25.000 = 190.000
        $this->assertDatabaseHas('periksa', [
            'id_daftar_poli' => $this->daftarPoli->id,
            'catatan' => 'Pasien flu biasa, istirahat dan minum obat teratur.',
            'biaya_periksa' => 190000,
        ]);

        $periksa = Periksa::where('id_daftar_poli', $this->daftarPoli->id)->firstOrFail();

        $this->assertDatabaseHas('detail_periksa', [
            'id_periksa' => $periksa->id,
            'id_obat' => $this->obatA->id,
        ]);
        $this->assertDatabaseHas('detail_periksa', [
            'id_periksa' => $periksa->id,
            'id_obat' => $this->obatB->id,
        ]);
    }

    public function test_dokter_can_update_existing_examination(): void
    {
        // First examination
        $periksa = Periksa::create([
            'id_daftar_poli' => $this->daftarPoli->id,
            'tgl_periksa' => now(),
            'catatan' => 'Pemeriksaan awal',
            'biaya_periksa' => 165000,
        ]);

        DetailPeriksa::create([
            'id_periksa' => $periksa->id,
            'id_obat' => $this->obatA->id,
        ]);

        // Update examination
        $response = $this->actingAs($this->dokter)->post(route('periksa-pasien.store'), [
            'id_daftar_poli' => $this->daftarPoli->id,
            'tgl_periksa' => now()->format('Y-m-d H:i:s'),
            'catatan' => 'Catatan diperbarui setelah tes lab',
            'obat' => [$this->obatB->id],
        ]);

        $response->assertRedirect(route('periksa-pasien.index'));
        $response->assertSessionHas('message', 'Data pemeriksaan pasien berhasil diperbarui.');

        // Total biaya updated: 150.000 + 25.000 = 175.000
        $this->assertDatabaseHas('periksa', [
            'id_daftar_poli' => $this->daftarPoli->id,
            'catatan' => 'Catatan diperbarui setelah tes lab',
            'biaya_periksa' => 175000,
        ]);

        $this->assertDatabaseMissing('detail_periksa', [
            'id_periksa' => $periksa->id,
            'id_obat' => $this->obatA->id,
        ]);
        $this->assertDatabaseHas('detail_periksa', [
            'id_periksa' => $periksa->id,
            'id_obat' => $this->obatB->id,
        ]);
    }

    public function test_dokter_cannot_examine_other_doctors_patient(): void
    {
        $otherDokter = User::factory()->create([
            'role' => 'dokter',
            'id_poli' => $this->poli->id,
        ]);

        $response = $this->actingAs($otherDokter)->get(route('periksa-pasien.create', $this->daftarPoli->id));
        $response->assertStatus(404);

        $responseStore = $this->actingAs($otherDokter)->post(route('periksa-pasien.store'), [
            'id_daftar_poli' => $this->daftarPoli->id,
            'tgl_periksa' => now()->format('Y-m-d H:i:s'),
            'catatan' => 'Tidak boleh memeriksa',
        ]);
        $responseStore->assertStatus(404);
    }
}
