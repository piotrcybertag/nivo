<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StanowiskaGrupaWynagrodzen extends Model
{
    protected $table = 'stanowiska_grupy_wynagrodzen';

    protected $fillable = [
        'uzytkownik_id',
        'indeks_grupy',
        'wynagrodzenie_od',
        'wynagrodzenie_do',
    ];

    protected $casts = [
        'indeks_grupy' => 'integer',
        'wynagrodzenie_od' => 'decimal:2',
        'wynagrodzenie_do' => 'decimal:2',
    ];

    public function uzytkownik(): BelongsTo
    {
        return $this->belongsTo(Uzytkownik::class, 'uzytkownik_id');
    }
}
