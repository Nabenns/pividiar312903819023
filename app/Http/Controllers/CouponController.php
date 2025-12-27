<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Coupon;

class CouponController extends Controller
{
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:coupons,code',
            'total' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon->isValid()) {
            return response()->json(['message' => 'Invalid or expired coupon.'], 422);
        }

        $discount = $coupon->calculateDiscount($request->total);
        $newTotal = max(0, $request->total - $discount);

        return response()->json([
            'success' => true,
            'coupon_id' => $coupon->id,
            'code' => $coupon->code,
            'discount_amount' => $discount,
            'new_total' => $newTotal,
        ]);
    }
}
