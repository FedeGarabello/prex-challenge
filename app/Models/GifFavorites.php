<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GifFavorites extends Model
{
    protected $fillable = [
        'gif_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
