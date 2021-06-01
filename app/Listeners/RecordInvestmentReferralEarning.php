<?php

namespace App\Listeners;

use App\Events\ActivatedInvestment;
use App\Models\Investment;
use App\Models\User;
use App\Models\Referral;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecordInvestmentReferralEarning
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
    public function handle(ActivatedInvestment $event)
    {
        $investment = $event->investment;
        if (isset($investment->user->referred_referral_code) && strlen($investment->user->referred_referral_code) > 0) {
            $investorInvestments = Investment::selectRaw('count(id) as totalInvestments')->where('user_id', $investment->user->id)->first();
            $totalInvestorInvestments = $investorInvestments->totalInvestments;
            if ($totalInvestorInvestments === 1) {
                $referredUser = User::where('referral_code', $investment->user->referred_referral_code)->first();
                if ($referredUser) {
                    $referral = Referral::where('owner_id', $referredUser->id)->where('referred_user_id', $investment->user->id)->first();
                    if ($referral) {
                        $referral->status = 'redeemed';
                        $referral->owner->referralTransaction->earnings = (((float) $investment->amount) * 2.5 * 0.01) + ((float) $referral->owner->referralTransaction->earnings);
                        $referral->save();
                        $referral->owner->referralTransaction->save();
                    }
                }
            }
        }
    }
}
