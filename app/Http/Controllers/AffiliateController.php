<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch coupons owned by the affiliate
        $coupons = $user->affiliateCoupons()->withCount('transactions')->get();

        // Calculate stats
        $totalEarnings = $user->affiliateCommissions()->where('status', 'paid')->sum('amount');
        $pendingEarnings = $user->affiliateCommissions()->where('status', 'pending')->sum('amount');
        $totalConversions = $coupons->sum('uses');
        
        // Fetch commission history
        $commissions = $user->affiliateCommissions()
            ->with(['transaction.user', 'transaction.plan'])
            ->latest()
            ->paginate(10);

        return view('affiliate.index', compact('coupons', 'totalEarnings', 'pendingEarnings', 'totalConversions', 'commissions'));
    }
}
