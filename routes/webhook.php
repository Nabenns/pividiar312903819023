<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webhook\MidtransWebhookController;

Route::post('/midtrans', [MidtransWebhookController::class, 'handle'])->name('webhook.midtrans');
