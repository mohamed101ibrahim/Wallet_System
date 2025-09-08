<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = ['title', 'body', 'read_at'];

    public function notifiable()
    {
        return $this->morphTo();
    }
}