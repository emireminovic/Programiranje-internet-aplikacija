<?php

namespace App\Models;

use App\Models\Termin;
use Illuminate\Database\Eloquent\Model;

class Frizer extends Model
{
    protected $fillable = [
        'user_id',
        'ime',
        'prezime',
        'email',
        'telefon',
        'slika',
        'cena',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function termini()
    {
        return $this->hasMany(Termin::class);
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}

public function messages()
{
    return $this->hasMany(\App\Models\Message::class);
}
}