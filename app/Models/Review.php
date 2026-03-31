<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'frizer_id',
        'ocena',
        'komentar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function frizer()
    {
        return $this->belongsTo(Frizer::class);
    }
}