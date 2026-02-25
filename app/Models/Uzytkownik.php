<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $hidden = [
        'password',
    ];
}
