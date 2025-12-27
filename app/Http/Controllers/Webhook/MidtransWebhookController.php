<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handle(\Illuminate\Http\Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        \Illuminate\Support\Facades\Log::info('Midtrans Webhook:', [
            'payload' => $request->all(),
            'calculated_signature' => $hashed,
            'received_signature' => $request->signature_key,
            'match' => $hashed == $request->signature_key
        ]);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $transaction = \App\Models\Transaction::where('midtrans_order_id', $request->order_id)->first();
                if ($transaction) {
                    $transaction->update(['status' => 'paid', 'payload' => $request->all()]);
                    
                    // Activate Subscription
                    $this->activateSubscription($transaction);
                }
            } elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                 $transaction = \App\Models\Transaction::where('midtrans_order_id', $request->order_id)->first();
                 if ($transaction) {
                    $transaction->update(['status' => 'failed', 'payload' => $request->all()]);
                 }
            }
        }
    }

    protected function activateSubscription($transaction)
    {
        $plan = $transaction->plan;
        $user = $transaction->user;

        $startsAt = now();
        
        $endsAt = match ($plan->billing_cycle) {
            'monthly' => now()->addMonth(),
            'yearly' => now()->addYear(),
            'lifetime' => now()->addYears(100),
            default => now()->addMonth(),
        };

        \App\Models\Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'status' => 'active',
        ]);
        
        // Assign role
        $roleToAssign = $plan->role_name ?? 'member';
        $user->assignRole($roleToAssign);
    }
}
