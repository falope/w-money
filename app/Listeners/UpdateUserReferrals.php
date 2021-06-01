<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserReferrals
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $registeredUser = $event->user;
        if(strlen($registeredUser->referred_referral_code) > 0) {
            $referredUser = User::where('referral_code', $registeredUser->referred_referral_code)->first();
            if ($referredUser) {
                $referral = new Referral;
                $referral->owner_id = $referredUser->id;
                $referral->referred_user_id = $registeredUser->id;
                $referral->save();
            }
        }
    }
}
