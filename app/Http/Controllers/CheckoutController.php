<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request, \App\Models\Plan $plan)
    {
        $user = auth()->user();
        $amount = $plan->price;
        $discount = 0;
        $couponId = null;

        // Check for coupon in request
        if ($request->has('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($amount);
                $amount = max(0, $amount - $discount);
                $couponId = $coupon->id;
            }
        }
        
        // Create pending transaction
        $transaction = \App\Models\Transaction::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'coupon_id' => $couponId,
            'subtotal' => $plan->price,
            'discount_amount' => $discount,
            'amount' => $amount,
            'status' => 'pending',
            'midtrans_order_id' => 'TRX-' . time() . '-' . $user->id,
        ]);

        // Generate Snap Token
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->midtrans_order_id,
                'gross_amount' => (int) $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $plan->id,
                    'price' => (int) $plan->price,
                    'quantity' => 1,
                    'name' => $plan->name,
                ],
            ],
        ];

        // Add discount item if applicable
        if ($discount > 0) {
            $params['item_details'][] = [
                'id' => 'DISCOUNT',
                'price' => -(int) $discount,
                'quantity' => 1,
                'name' => 'Discount Coupon',
            ];
        }

        $midtrans = new \App\Services\MidtransService();
        $snapToken = $midtrans->getSnapToken($params);

        return view('checkout', compact('plan', 'snapToken'));
    }
}
