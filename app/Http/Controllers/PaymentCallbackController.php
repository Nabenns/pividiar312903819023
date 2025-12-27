<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        Log::info('Midtrans Callback', $payload);

        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];
        $transactionStatus = $payload['transaction_status'];

        $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

        if (! $transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transactionStatus == 'capture') {
            if ($payload['fraud_status'] == 'challenge') {
                $transaction->update(['status' => 'pending']);
            } else {
                $transaction->update(['status' => 'paid']);
                $this->activateMembership($transaction);
            }
        } elseif ($transactionStatus == 'settlement') {
            $transaction->update(['status' => 'paid']);
            $this->activateMembership($transaction);
        } elseif ($transactionStatus == 'pending') {
            $transaction->update(['status' => 'pending']);
        } elseif ($transactionStatus == 'deny') {
            $transaction->update(['status' => 'failed']);
        } elseif ($transactionStatus == 'expire') {
            $transaction->update(['status' => 'failed']);
        } elseif ($transactionStatus == 'cancel') {
            $transaction->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Callback received']);
    }

    public function activateMembership(Transaction $transaction)
    {
        $user = $transaction->user;
        
        // Assign member role
        $user->assignRole('member');
        
        // Handle Coupon Logic
        if ($transaction->coupon_id) {
            Log::info('Incrementing usage for coupon: ' . $transaction->coupon->code);
            // Increment coupon usage
            $transaction->coupon->increment('uses');

            // Record affiliate commission if applicable
            $this->recordAffiliateCommission($transaction);
        }
    }

    protected function recordAffiliateCommission(Transaction $transaction)
    {
        Log::info('Attempting to record commission for Transaction ID: ' . $transaction->id);
        if ($transaction->coupon_id && $transaction->coupon->affiliate_user_id) {
            Log::info('Affiliate found: ' . $transaction->coupon->affiliate_user_id);
            $coupon = $transaction->coupon;

            // Calculate commission
            $commissionAmount = $coupon->calculateCommission($transaction->amount); // Commission based on paid amount

            // Create commission record
            \App\Models\AffiliateCommission::create([
                'affiliate_user_id' => $coupon->affiliate_user_id,
                'transaction_id' => $transaction->id,
                'amount' => $commissionAmount,
                'status' => 'pending', // Pending until payout
            ]);
        }
    }
}
