<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralCode extends Model
{
    protected $fillable = ['code', 'owner_id', 'owner_type', 'redeemed_by','redeemed_at'];
    public function owner()
    {
        return $this->morphTo();
    }

    public function redeemer()
    {
        return $this->belongsTo(User::class, 'redeemed_by');
    }
}