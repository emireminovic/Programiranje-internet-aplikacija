<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'frizer_id',
        'receiver_id',
        'naslov',
        'poruka',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function frizer()
    {
        return $this->belongsTo(Frizer::class);
    }

    public function receiver()
{
    return $this->belongsTo(User::class, 'receiver_id');
}
}