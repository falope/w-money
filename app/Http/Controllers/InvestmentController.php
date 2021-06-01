<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Investment;
use App\Models\Plan;
use App\Models\User;
use App\Events\ActivatedInvestment;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InvestmentController extends Controller
{

    public function payInformation(Request $request)
    {
        $investment = Investment::where('id', $request->investment_id ?? NULL)->where('status', 'created')->where('user_id', Auth::user()->id)->first();
        if (!$investment) return redirect()->route('dashboard')->with('error', 'Oops, investment not found');
        return view('dashboard.user.pay-information', compact('investment'));
    }

    public function showPendingInvestments(Request $request)
    {

        $userSearch = $request->search_user;
        $investmentSlug = $request->search_investment;
        if ($investmentSlug === 'all') $investmentSlug = NULL;
        $investments = Investment::whereHas('user', function ($query)  use ($userSearch) {
            $query->where('status', 'active');
            if (isset($userSearch)) $query->where('email', 'LIKE', "%{$userSearch}%")->orWhere('name', 'LIKE', "%{$userSearch}%")->orWhere('phone_number', 'LIKE', "%{$userSearch}%")->orWhere('bank_name', 'LIKE', "%{$userSearch}%")->orWhere('bank_account_number', 'LIKE', "%{$userSearch}%");
        })->whereHas('plan', function ($query)  use ($investmentSlug) {
            if (isset($investmentSlug)) $query->where('slug', $investmentSlug);
        })->where('status', 'created')->orderBy('id', 'desc')->paginate(10);
        $plans = Plan::all();

        return view('dashboard.admin.pending-investments', compact('investments', 'plans'));
    }

    public function showActiveInvestments(Request $request)
    {
        $user = Auth::user();
        $investments = NULL;
        $plans = NULL;
        if ($user->account_type === User::USER_ACCOUNT_TYPE) {
            $investments = Investment::where('user_id', Auth::user()->id)->where('status', 'active')->orderBy('id', 'desc')->paginate(10);
        } else {
            $userSearch = $request->search_user;
            $investmentSlug = $request->search_investment;
            if ($investmentSlug === 'all') $investmentSlug = NULL;
            $investments = Investment::whereHas('user', function ($query)  use ($userSearch) {
                $query->where('status', 'active');
                if (isset($userSearch)) $query->where('email', 'LIKE', "%{$userSearch}%")->orWhere('name', 'LIKE', "%{$userSearch}%")->orWhere('phone_number', 'LIKE', "%{$userSearch}%")->orWhere('bank_name', 'LIKE', "%{$userSearch}%")->orWhere('bank_account_number', 'LIKE', "%{$userSearch}%");
            })->whereHas('plan', function ($query)  use ($investmentSlug) {
                if (isset($investmentSlug)) $query->where('slug', $investmentSlug);
            })->where('status', '=', 'active')->orderBy('id', 'desc')->paginate(10);
            $plans = Plan::all();
        }
        return view(Auth::user()->account_type === User::USER_ACCOUNT_TYPE ? 'dashboard.user.active-investments' : 'dashboard.admin.active-investments', compact('investments', 'user', 'plans'));
    }

    public function showCompletedInvestments(Request $request)
    {
        $user = Auth::user();
        $investments = NULL;
        $plans = NULL;
        if ($user->account_type == User::USER_ACCOUNT_TYPE) {
            $investments = Investment::where('user_id', Auth::user()->id)->where('status', 'completed')->orderBy('id', 'desc')->paginate(10);
        } else {
            $userSearch = $request->search_user;
            $investmentSlug = $request->search_investment;
            if ($investmentSlug === 'all') $investmentSlug = NULL;
            $investments = Investment::whereHas('user', function ($query)  use ($userSearch) {
                $query->where('status', 'active');
                if (isset($userSearch)) $query->where('email', 'LIKE', "%{$userSearch}%")->orWhere('name', 'LIKE', "%{$userSearch}%")->orWhere('phone_number', 'LIKE', "%{$userSearch}%")->orWhere('bank_name', 'LIKE', "%{$userSearch}%")->orWhere('bank_account_number', 'LIKE', "%{$userSearch}%");
            })->whereHas('plan', function ($query)  use ($investmentSlug) {
                if (isset($investmentSlug)) $query->where('slug', $investmentSlug);
            })->where('status', '=', 'completed')->orderBy('id', 'desc')->paginate(10);
            $plans = Plan::all();
        }
        return view(Auth::user()->account_type === User::USER_ACCOUNT_TYPE ? 'dashboard.user.completed-investments' : 'dashboard.admin.completed-investments', compact('investments', 'user', 'plans'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $plan = Plan::where('slug', $request->plan_slug ?? NULL)->first();
        if (!$plan) return redirect()->route('partnership')->with('error', 'Oops, an error occurred, try again');
        $investment = new Investment;
        $investment->user_id = $user->id;
        $investment->amount = $plan->amount;
        $investment->plan_id = $plan->id;
        $investment->plan_meta = $plan->meta;
        $investment->duration = $plan->duration;
        $investment->duration_type = $plan->duration_type;
        $investment->unit = $request->unit;
        $investment->roi = $plan->getRoi((int) $request->unit);
        if ($investment->roi == 0) return redirect()->back()->with('error', 'Selected unit is not available');
        if ($investment->save()) return redirect()->route('investment-pay-information', ['investment_id' => $investment->id])->with('success', "Proceed with payment to activate investment");
        return redirect()->route('partnership')->with('error', 'Oops, an error occurred, try again');
    }

    public function activate(Request $request)
    {
        $investment = Investment::where('id', $request->investment_id ?? NULL)->where('status', Investment::CREATED)->first();
        if (!$investment) return redirect()->back()->with('error', 'Oops, investment not found');
        $investment->status = Investment::ACTIVE;
        $investment->activated_on = date('Y-m-d H:i:s');
        if ($investment->save()) {
            event(new ActivatedInvestment($investment));
            return redirect()->route('active-investments')->with('success', 'Investment has been activated');
        }
        return redirect()->back()->with('error', 'Oops, an error occurred, try again');
    }

    public function withdraw(Request $request)
    {
        $investment = Investment::where('id', $request->investment_id ?? NULL)->where('status', Investment::ACTIVE)->first();
        if (!$investment) return redirect()->back()->with('error', 'Oops, investment not found');
        $investment->status = Investment::COMPLETED;
        $investment->completed_on = date('Y-m-d H:i:s');
        $investment->withdraw_amount = $request->amount;
        if ($investment->save()) return redirect()->route('completed-investments')->with('success', 'Investment has been completed');
        return redirect()->back()->with('error', 'Oops, an error occurred, try again');
    }

    public function archive(Request $request)
    {
        if (Auth::user()->account_type === User::USER_ACCOUNT_TYPE) {
            $investment = Investment::where('id', $request->investment_id ?? NULL)->where('status', Investment::CREATED)->where('user_id', Auth::user()->id)->first();
        } else {
            $investment = Investment::where('id', $request->investment_id ?? NULL)->where('status', Investment::CREATED)->first();
        }
        if (!$investment) return redirect()->back()->with('error', 'Oops, investment not found');
        $investment->status = Investment::ARCHIVED;
        if ($investment->save()) return redirect()->back()->with('success', 'Investment has been deleted');
        return redirect()->back()->with('error', 'Oops, an error occurred, try again');
    }

    public function exportActive($type)
    {
        if($type == "all"){
            $response = new StreamedResponse(function () {
                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Investor Name',
                    'Investor Email',
                    'Plan',
                    'Amount',
                    'Unit',
                    'ROI',
                    'Phone Number',
                    'Bank Name',
                    'Bank Account Name',
                    'Start Date',
                    'End Date',
                ]);

                Investment::where('status', 'active')->chunk(500, function ($investments) use ($handle) {
                    foreach ($investments as $investment) {
                        fputcsv($handle, [
                            $investment->user->name,
                            $investment->user->email,
                            $investment->plan->name,
                            '₦' . number_format($investment->amount, 2),
                            $investment->unit,
                            $investment->roi,
                            $investment->user->phone_number,
                            $investment->user->bank_name,
                            $investment->user->bank_account_number,
                            date('F j, Y', strtotime($investment->activated_on)),
                            date('F j, Y', strtotime(date('Y-m-d', strtotime('+' . $investment->duration . ' ' . $investment->duration_type . 's', strtotime($investment->activated_on)))))
                        ]);
                    }
                });
                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="homeflex-active-investments-export.csv"',
            ]);

            return $response;
        }else{
            $planInView = Plan::where('slug', $type)->first();
            $planId = $planInView->id;

            $response = new StreamedResponse(function () use($planId) {
                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Investor Name',
                    'Investor Email',
                    'Plan',
                    'Amount',
                    'Unit',
                    'ROI',
                    'Phone Number',
                    'Bank Name',
                    'Bank Account Name',
                    'Start Date',
                    'End Date',
                ]);

                Investment::where('status', 'active')->where('plan_id', $planId)->chunk(500, function ($investments) use ($handle) {
                    foreach ($investments as $investment) {
                        fputcsv($handle, [
                            $investment->user->name,
                            $investment->user->email,
                            $investment->plan->name,
                            '₦' . number_format($investment->amount, 2),
                            $investment->unit,
                            $investment->roi,
                            $investment->user->phone_number,
                            $investment->user->bank_name,
                            $investment->user->bank_account_number,
                            date('F j, Y', strtotime($investment->activated_on)),
                            date('F j, Y', strtotime(date('Y-m-d', strtotime('+' . $investment->duration . ' ' . $investment->duration_type . 's', strtotime($investment->activated_on)))))
                        ]);
                    }
                });
                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="homeflex-active-investments-export.csv"',
            ]);

            return $response;
        }
    }
    public function exportPending($type)
    {
        if($type == "all"){
            $response = new StreamedResponse(function () {
                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Investor Name',
                    'Investor Email',
                    'Plan',
                    'Amount',
                    'Unit',
                    'ROI',
                    'Phone Number',
                    'Bank Name',
                    'Bank Account Name',
                ]);

                Investment::where('status', 'created')->chunk(500, function ($investments) use ($handle) {
                    foreach ($investments as $investment) {
                        fputcsv($handle, [
                            $investment->user->name,
                            $investment->user->email,
                            $investment->plan->name,
                            '₦' . number_format($investment->amount, 2),
                            $investment->unit,
                            $investment->roi,
                            $investment->user->phone_number,
                            $investment->user->bank_name,
                            $investment->user->bank_account_number
                        ]);
                    }
                });
                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="homeflex-pending-investments-export.csv"',
            ]);

            return $response;
        }else{
            $planInView = Plan::where('slug', $type)->first();
            $planId = $planInView->id;

            $response = new StreamedResponse(function () use($planId){
                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Investor Name',
                    'Investor Email',
                    'Plan',
                    'Amount',
                    'Unit',
                    'ROI',
                    'Phone Number',
                    'Bank Name',
                    'Bank Account Name',
                ]);

                Investment::where('status', 'created')->where('plan_id', $planId)->chunk(500, function ($investments) use ($handle) {
                    foreach ($investments as $investment) {
                        fputcsv($handle, [
                            $investment->user->name,
                            $investment->user->email,
                            $investment->plan->name,
                            '₦' . number_format($investment->amount, 2),
                            $investment->unit,
                            $investment->roi,
                            $investment->user->phone_number,
                            $investment->user->bank_name,
                            $investment->user->bank_account_number
                        ]);
                    }
                });
                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="homeflex-pending-investments-export.csv"',
            ]);

            return $response;
        }
    }
    public function exportCompleted($type)
    {
        if($type == "all"){
            $response = new StreamedResponse(function () {
                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Investor Name',
                    'Investor Email',
                    'Plan',
                    'Amount',
                    'Unit',
                    'ROI',
                    'Phone Number',
                    'Bank Name',
                    'Bank Account Name',
                    'Start Date',
                    'End Date',
                ]);

                Investment::where('status', 'completed')->chunk(500, function ($investments) use ($handle) {
                    foreach ($investments as $investment) {
                        fputcsv($handle, [
                            $investment->user->name,
                            $investment->user->email,
                            $investment->plan->name,
                            '₦' . number_format($investment->amount, 2),
                            $investment->unit,
                            $investment->roi,
                            $investment->user->phone_number,
                            $investment->user->bank_name,
                            $investment->user->bank_account_number,
                            date('F j, Y', strtotime($investment->activated_on)),
                            date('F j, Y', strtotime($investment->completed_on))
                        ]);
                    }
                });
                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="homeflex-completed-investments-export.csv"',
            ]);

            return $response;
        }else{
            $planInView = Plan::where('slug', $type)->first();
            $planId = $planInView->id;

            $response = new StreamedResponse(function () use($planId) {
                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Investor Name',
                    'Investor Email',
                    'Plan',
                    'Amount',
                    'Unit',
                    'ROI',
                    'Phone Number',
                    'Bank Name',
                    'Bank Account Name',
                    'Start Date',
                    'End Date',
                ]);

                Investment::where('status', 'completed')->where('plan_id', $planId)->chunk(500, function ($investments) use ($handle) {
                    foreach ($investments as $investment) {
                        fputcsv($handle, [
                            $investment->user->name,
                            $investment->user->email,
                            $investment->plan->name,
                            '₦' . number_format($investment->amount, 2),
                            $investment->unit,
                            $investment->roi,
                            $investment->user->phone_number,
                            $investment->user->bank_name,
                            $investment->user->bank_account_number,
                            date('F j, Y', strtotime($investment->activated_on)),
                            date('F j, Y', strtotime($investment->completed_on))
                        ]);
                    }
                });
                fclose($handle);
            }, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="homeflex-completed-investments-export.csv"',
            ]);

            return $response;
        }
    }
}
