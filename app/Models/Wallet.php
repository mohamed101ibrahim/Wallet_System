<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['balance', 'held'];

    public function owner()
    {
        return $this->morphTo();
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function requests()
    {
        return $this->hasMany(WalletRequest::class);
    }
}