<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $activeDays = $user->created_at->diffInDays(now());
        // If created today, show 1 day
        $activeDays = $activeDays < 1 ? 1 : $activeDays;
        
        $lessonsCount = Lesson::count();
        
        $totalSpent = $user->transactions()->where('status', 'paid')->sum('amount');
        
        $transactions = $user->transactions()
            ->where('status', 'paid')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('activeDays', 'lessonsCount', 'totalSpent', 'transactions'));
    }
}
