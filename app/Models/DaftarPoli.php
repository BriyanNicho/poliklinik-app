<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DaftarPoli extends Model
{
    protected $table = 'daftar_poli';

    protected $fillable = ['id_pasien', 'id_jadwal', 'keluhan', 'no_antrian'];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalPeriksa::class, 'id_jadwal');
    }

    public function jadwalPeriksa(): BelongsTo
    {
        return $this->jadwal();
    }

    public function periksa(): HasOne
    {
        return $this->hasOne(Periksa::class, 'id_daftar_poli');
    }

    public function periksas(): HasMany
    {
        return $this->hasMany(Periksa::class, 'id_daftar_poli');
    }
}
