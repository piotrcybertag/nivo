<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Uzytkownik extends Model
{
    protected $table = 'uzytkownicy';

    protected $fillable = [
        'email',
        'imie_nazwisko',
        'typ',
        'plan',
        'password',
        'login_link_token',
        'stanowiska_kolejnosc',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'stanowiska_kolejnosc' => 'array',
    ];

    public function stanowiskaGrupyWynagrodzen(): HasMany
    {
        return $this->hasMany(StanowiskaGrupaWynagrodzen::class, 'uzytkownik_id');
    }
}
