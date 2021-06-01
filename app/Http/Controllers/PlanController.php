<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Plan\CreatePlanRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Plan\UpdatePlanRequest;
use App\Models\Plan;
use App\Models\User;

class PlanController extends Controller
{

    public function create(CreatePlanRequest $request)
    {
        $plan = new Plan;
        $plan->name = $request->name;
        $plan->duration = $request->duration;
        $plan->duration_type = $request->duration_type;
        $plan->amount = $request->amount;
        $plan->meta = json_encode(json_decode((string) $request->meta), true);
        $plan->slug = str_slug($plan->name, '-');
        $plan->image = $request->imageUrl;
        $planExist = Plan::where('slug', $plan->slug)->first();
        if ($planExist)  return redirect()->back()->with('error', 'Plan already exists');
        if ($plan->save()) return redirect()->route('partnership')->with('success', 'Plan has been created');
        return redirect()->back()->with('error', 'Oops, an error occurred. Try again');
    }

    public function update(UpdatePlanRequest $request)
    {
        $plan = Plan::where('slug', $request->slug ?? NULL)->first();
        if (!$plan) return redirect()->back()->with('error', 'Plan does not exist');
        $plan->name = $request->name ?? $plan->name;
        $plan->duration = $request->duration ?? $plan->duration;
        $plan->duration_type = $request->duration_type ?? $plan->duration_type;
        $plan->amount = $request->amount ?? $plan->amount;
        $plan->slug = str_slug($plan->name, '-');
        $plan->image = $request->imageUrl ?? $plan->image;
        if ($plan->save()) return redirect()->back()->with('success', 'Plan has been updated');
        return redirect()->back()->with('error', 'Oops, an error occurred. Try again');
    }

    public function delete(UpdatePlanRequest $request)
    {
        $plan = Plan::where('slug', $request->slug);
        if (!$plan) return redirect()->route('admin-plans')->with('error', 'Plan does not exist');
        $plan->status = 'archived';
        if ($plan->save()) return redirect()->route('admin-plans')->with('success', 'Plan has been removed');
        return redirect()->route('admin-plans')->with('error', 'Oops, an error occurred. Try again');
    }

    public function showPartnership()
    {
        $user = Auth::user();
        $plans = Plan::where('status', '!=', 'archived')->orderBy('id', 'desc')->orderBy('id', 'desc')->paginate(4);
        return view($user->account_type === User::USER_ACCOUNT_TYPE ? 'dashboard.user.partnership' : 'dashboard.admin.partnership', compact('plans'));
    }

    public function add()
    {
        return view('dashboard.admin.add-plan');
    }
    public function edit(Request $request)
    {
        $plan = Plan::where('id', $request->plan_id ?? NULL)->where('status', 'active')->first();
        if (!$plan) return redirect()->back()->with('error', 'Plan not found');
        return view('dashboard.admin.edit-plan', compact('plan'));
    }

    private function uploadImage($image): string
    {
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        return $name;
    }

    private function removeImage(string $imagePath)
    {
        $path = public_path() . "/images/" . $imagePath;
        @unlink($path);
    }
}
