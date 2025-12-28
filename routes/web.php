<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AcademyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pricing', [\App\Http\Controllers\PricingController::class, 'index'])->name('pricing');
Route::get('/checkout/{plan}', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/academy', [\App\Http\Controllers\AcademyController::class, 'index'])->name('academy.index');
    Route::get('/academy/{lesson:slug}', [\App\Http\Controllers\AcademyController::class, 'lesson'])->name('academy.lesson');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/coupon/validate', [App\Http\Controllers\CouponController::class, 'validateCoupon'])->name('coupon.validate');
Route::get('/affiliate', [App\Http\Controllers\AffiliateController::class, 'index'])->name('affiliate.index');





require __DIR__.'/auth.php';
