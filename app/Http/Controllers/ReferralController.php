<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReferralTransaction;
use App\Models\ReferralPayout;

class ReferralController extends Controller
{
    public function show()
    {
        return view('dashboard.user.referrals');
    }

    public function manage()
    {
        $referrals = ReferralTransaction::where('earnings', '>', 0)->orderBy('id', 'desc')->paginate(10);
        return view('dashboard.admin.manage-referrals', compact('referrals'));
    }

    public function pay(Request $request)
    {
        $referralTransaction = ReferralTransaction::where('id', $request->transaction_id ?? NULL)->where('earnings', '>', 0)->first();
        if (!$referralTransaction) return redirect()->back()->with('error', 'Could not retrieve transaction');
        $payout = new ReferralPayout;
        $payout->amount = $referralTransaction->earnings;
        $payout->user_id = $referralTransaction->user_id;
        $referralTransaction->earnings = 0;
        if ($payout->save() && $referralTransaction->save()) return redirect()->back()->with('success', 'Payout has been recorded');
        return redirect()->back()->with('error', 'Oops, an error occurred');
    }
}
