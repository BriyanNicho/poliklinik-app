<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    protected $table = 'poli';

    protected $fillable = ['nama_poli', 'keterangan'];

    public function dokters(): HasMany
    {
        return $this->hasMany(User::class, 'id_poli');
    }

    public function users(): HasMany
    {
        return $this->dokters();
    }

    public function jadwalPeriksa(): HasMany
    {
        return $this->hasMany(JadwalPeriksa::class, 'id_poli');
    }
}
