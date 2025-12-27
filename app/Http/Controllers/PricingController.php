<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $plans = \App\Models\Plan::where('is_active', true)->get();

        return view('pricing', compact('plans'));
    }
}
