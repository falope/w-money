<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Investment;
use App\Models\Referral;
use App\Models\ReferralPayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class  UserController extends Controller
{

    public function showDashboard(Request $request)
    {
        $totalPartnerships = 0;
        $totalROI = 0;
        $totalReferrals = 0;
        $totalReferralEarnings = 0;
        $totalUsers = 0;
        $totalPayout = 0;
        $investments = NULL;

        if (Auth::user()->account_type == User::USER_ACCOUNT_TYPE) {
            $userInvestments = Investment::selectRaw('SUM(CAST(amount AS DOUBLE PRECISION)*unit) as totalPartnerships, AVG(roi) as totalROI')->whereIn('status', ['active', 'completed'])->where('user_id', Auth::user()->id)->first();
            $totalPartnerships = $userInvestments->totalPartnerships;
            $totalROI = $userInvestments->totalROI;
            $totalReferrals = Referral::where('owner_id', Auth::user()->id)->count();
            $investments = Investment::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
            $referralPayout = ReferralPayout::selectRaw('SUM(CAST(amount AS DOUBLE PRECISION)) as totalReferralEarnings')->where('user_id', Auth::user()->id)->first();
            $totalReferralEarnings = $referralPayout->totalReferralEarnings;
        } else {
            $usersInvestment = Investment::selectRaw('SUM(CAST(amount AS DOUBLE PRECISION)*unit) as totalPartnerships, AVG(roi) as totalROI')->where('status', 'active')->orWhere('status', 'completed')->first();
            $totalPartnerships = $usersInvestment->totalPartnerships;
            $completedUsersInvestment = Investment::selectRaw('SUM(CAST(amount AS DOUBLE PRECISION)*unit) as totalPayout')->where('status', 'completed')->first();
            $totalROI = $usersInvestment->totalROI;
            $totalPayout = $completedUsersInvestment->totalPayout;
            $totalUsers = User::where('status', 'active')->count();
        }

        return view(Auth::user()->account_type === User::USER_ACCOUNT_TYPE ? 'dashboard.user.home' : 'dashboard.admin.home', compact('totalUsers', 'totalPayout', 'totalROI', 'totalPartnerships', 'totalReferrals', 'investments', 'totalReferralEarnings'));
    }

    public function showUsers(Request $request)
    {

        $userSearch = $request->search_user;
        $users = User::where('status', 'active')->where('account_type', User::USER_ACCOUNT_TYPE);
        if (isset($userSearch)) $users = $users->where('email', 'LIKE', "%{$userSearch}%")->orWhere('name', 'LIKE', "%{$userSearch}%")->orWhere('phone_number', 'LIKE', "%{$userSearch}%")->orWhere('bank_name', 'LIKE', "%{$userSearch}%")->orWhere('bank_account_number', 'LIKE', "%{$userSearch}%");
        $users = $users->orderBy('id', 'desc')->paginate(10);
        return view('dashboard.admin.users', compact('users'));
    }

    public function deleteUser(Request $request)
    {
        $user = User::where('status', 'active')->where('id', $request->user_id ?? null)->where('account_type', User::USER_ACCOUNT_TYPE)->first();
        if (!$user)
            return redirect()->back()->with('error', 'User does not exist');
        $user->status = 'deleted';
        if ($user->save()) return redirect()->route('show-users')->with('success', 'User has been deleted');
        return redirect()->back()->with('error', 'Oops, an error occurred, try again');
    }

    public function showProfile()
    {
        return view('dashboard.user.profile');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->country = $request->country;

        if ($user->account_type == User::USER_ACCOUNT_TYPE) {
            $user->bank_name = $request->bank_name;
            $user->bank_account_number = $request->bank_account_number;
        }

        if ($user->save()) return redirect()->route('profile')->with('success', 'Profile has been updated');
        return redirect()->route('profile')->with('error', 'Oops, an error occurred, try again');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $oldPassword = Hash::make($request->old_password);
        if (!Hash::check($oldPassword, $user->password)) return redirect()->route('profile')->with('error', 'Old password is in correct');
        $newPassword = Hash::make($request->new_password);
        $user->password = $newPassword;
        if ($user->save()) return redirect()->route('profile')->with('success', 'Password has been updated');
        return redirect()->route('profile')->with('error', 'Oops, an error occurred, try again');
    }

    public function loginUserSession(Request $request)
    {
        $user = User::where('id', $request->user_id ?? NULL)->first();
        if (!$user) return redirect()->back()->with('error', 'User not found');
        $request->session()->regenerate();
        Auth::loginUsingId($user->id);
        return redirect()->route('dashboard')->with('success', 'Now logged in as ' . $user->name);
    }

    public function export(Request $request)
    {
        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'name',
                'email',
                'phone_number'
            ]);

            User::chunk(500, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->name,
                        $user->email,
                        $user->phone_number,
                    ]);
                }
            });
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="homeflex-users-export.csv"',
        ]);

        return $response;
    }
}
