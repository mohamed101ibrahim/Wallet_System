<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['name', 'email', 'password'];

    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_role');
    }

    public function referralCodes()
    {
        return $this->morphMany(ReferralCode::class, 'owner');
    }

    public function apiTokens()
    {
        return $this->morphMany(ApiToken::class, 'tokenable');
    }

    public function requestsReviewed()
    {
        return $this->hasMany(WalletRequest::class, 'reviewed_by');
    }

    public function hasPermission(string $slug): bool
    {
        return $this->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->contains('slug', $slug);
    }
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}