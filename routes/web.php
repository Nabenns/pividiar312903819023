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

    Route::get('/tools/calculator', [\App\Http\Controllers\ToolsController::class, 'calculator'])->name('tools.calculator');
    Route::get('/tools/calendar', [\App\Http\Controllers\ToolsController::class, 'calendar'])->name('tools.calendar');

    Route::get('/journal', [\App\Http\Controllers\JournalController::class, 'index'])->name('journal.index');
    Route::post('/journal', [\App\Http\Controllers\JournalController::class, 'store'])->name('journal.store');
    Route::put('/journal/{journal}', [\App\Http\Controllers\JournalController::class, 'update'])->name('journal.update');
    Route::delete('/journal/{journal}', [\App\Http\Controllers\JournalController::class, 'destroy'])->name('journal.destroy');

    // Spot Journal Routes
    Route::get('/journal/spot', [\App\Http\Controllers\SpotJournalController::class, 'index'])->name('journal.spot.index');
    Route::post('/journal/spot', [\App\Http\Controllers\SpotJournalController::class, 'store'])->name('journal.spot.store');
    Route::put('/journal/spot/{spot}', [\App\Http\Controllers\SpotJournalController::class, 'update'])->name('journal.spot.update');
    Route::delete('/journal/spot/{spot}', [\App\Http\Controllers\SpotJournalController::class, 'destroy'])->name('journal.spot.destroy');
    
    // Proxy Routes for CoinGecko (Avoid CORS/Rate Limits)
    Route::get('/journal/spot/proxy/coins', [\App\Http\Controllers\SpotJournalController::class, 'proxyCoinList'])->name('journal.spot.proxy.coins');
    Route::get('/journal/spot/proxy/prices', [\App\Http\Controllers\SpotJournalController::class, 'proxyPrices'])->name('journal.spot.proxy.prices');
});

Route::post('/coupon/validate', [App\Http\Controllers\CouponController::class, 'validateCoupon'])->name('coupon.validate');
Route::get('/affiliate', [App\Http\Controllers\AffiliateController::class, 'index'])->name('affiliate.index');





require __DIR__.'/auth.php';
