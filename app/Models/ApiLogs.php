<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLogs extends Model
{
    protected $fillable = [
        'user_id',
        'service',
        'request',
        'response_code',
        'response_body',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
