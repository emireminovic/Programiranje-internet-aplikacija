<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Termin extends Model
{
    protected $fillable = [
        'frizer_id',
        'user_id',
        'datum',
        'vreme',
        'status',
    ];


    public function frizer()
{
    return $this->belongsTo(Frizer::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}