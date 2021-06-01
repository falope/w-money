<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const USER_ACCOUNT_TYPE = 'user';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'sex', 'phone_number', 'referred_referral_code', 'referral_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function referrals()
    {
        return $this->hasMany(\App\Models\Referral::class, 'owner_id');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function referralTransaction()
    {
        return $this->hasOne(ReferralTransaction::class);
    }

    public function referralPayouts()
    {
        return $this->hasMany(ReferralPayout::class);
    }
}
