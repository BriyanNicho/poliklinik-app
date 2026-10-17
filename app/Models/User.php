<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nama', 'alamat', 'no_ktp', 'no_hp', 'no_rm', 'email', 'password', 'role', 'id_poli'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function poli(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }

    public function jadwalPeriksas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JadwalPeriksa::class, 'id_dokter');
    }

    public function jadwalPeriksa(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->jadwalPeriksas();
    }
}
