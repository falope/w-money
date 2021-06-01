<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $plans = Plan::where('status', 'active')->orderBy('id', 'desc')->paginate(10);
        return view('presentational.home', compact('plans'));
    }
}
