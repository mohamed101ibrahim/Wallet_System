<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $fillable = ['token_hash', 'abilities', 'last_used_at'];

    protected $casts = [
        'abilities' => 'array',
        'last_used_at' => 'datetime',
    ];

    public function tokenable()
    {
        return $this->morphTo();
    }
}