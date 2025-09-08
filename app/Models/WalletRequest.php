<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletRequest extends Model
{
    protected $fillable = [
        'type',
        'amount',
        'status',
        'requested_by_type',
        'requested_by_id',
        'reference',
        'rejection_reason',
        'reviewed_by',
        'wallet_id'
    ];
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function requestedBy()
    {
        return $this->morphTo();
    }

    public function reviewer()
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }
}