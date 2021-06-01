<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Referral extends Model

{

    protected $fillable = ['owner_id', 'referred_user_id'];
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function investor()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}
