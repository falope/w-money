<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Referral;
use App\Models\User;
use App\Models\ReferralTransaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateReferralTransaction
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
        $referralTransaction = new ReferralTransaction;
        $referralTransaction->user_id = $registeredUser->id;
        $referralTransaction->earnings = 0;
        $referralTransaction->save();
    }
}
