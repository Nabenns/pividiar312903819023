<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouponSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_coupon_validation_logic()
    {
        $coupon = Coupon::create([
            'code' => 'TEST10',
            'discount_type' => 'percent',
            'discount_amount' => 10,
            'is_active' => true,
        ]);

        $response = $this->postJson(route('coupon.validate'), [
            'code' => 'TEST10',
            'total' => 100000,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'code' => 'TEST10',
                'discount_amount' => 10000,
                'new_total' => 90000,
            ]);
    }

    public function test_affiliate_commission_recording()
    {
        // 1. Setup Data
        \Spatie\Permission\Models\Role::create(['name' => 'member']);
        
        $affiliate = User::factory()->create();
        $buyer = User::factory()->create();
        $plan = Plan::create([
            'name' => 'Premium Plan',
            'price' => 100000,
            'slug' => 'premium-plan',
            'billing_cycle' => 'monthly',
            'features' => [],
        ]);

        $coupon = Coupon::create([
            'code' => 'AFF10',
            'discount_type' => 'percent',
            'discount_amount' => 10,
            'affiliate_user_id' => $affiliate->id,
            'commission_type' => 'percent',
            'commission_amount' => 20, // 20% commission
            'is_active' => true,
        ]);

        // 2. Create Transaction with Coupon
        $transaction = Transaction::create([
            'user_id' => $buyer->id,
            'plan_id' => $plan->id,
            'coupon_id' => $coupon->id,
            'amount' => 90000, // Discounted price
            'subtotal' => 100000,
            'discount_amount' => 10000,
            'status' => 'pending',
            'midtrans_order_id' => 'TRX-TEST-' . time(),
        ]);

        // 3. Simulate Payment Callback (Success)
        $controller = new \App\Http\Controllers\PaymentCallbackController();
        
        // We need to mock the request or directly call the protected method via reflection, 
        // but for integration test, let's hit the endpoint if possible, or just manually trigger the logic.
        // Since the logic is in a protected method called by handle(), let's simulate the handle() call.
        
        $payload = [
            'order_id' => $transaction->midtrans_order_id,
            'status_code' => '200',
            'gross_amount' => '90000.00',
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
        ];

        $response = $this->postJson('/api/midtrans-callback', $payload); 
        $response->assertStatus(200);

        // 4. Verify Commission
        $this->assertDatabaseHas('affiliate_commissions', [
            'affiliate_user_id' => $affiliate->id,
            'transaction_id' => $transaction->id,
            'amount' => 18000, // 20% of 90,000 (paid amount)
            'status' => 'pending',
        ]);

        // Verify Coupon Usage Incremented
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'uses' => 1,
        ]);
    }

    public function test_regular_coupon_usage_increment()
    {
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'member']);
        
        $coupon = Coupon::create([
            'code' => 'REGULAR10',
            'discount_type' => 'fixed',
            'discount_amount' => 10000,
            'is_active' => true,
        ]);

        $transaction = Transaction::create([
            'user_id' => User::factory()->create()->id,
            'plan_id' => Plan::create([
                'name' => 'Regular Plan',
                'price' => 100000,
                'slug' => 'regular-plan',
                'billing_cycle' => 'monthly',
                'features' => [],
            ])->id,
            'coupon_id' => $coupon->id,
            'amount' => 90000,
            'subtotal' => 100000,
            'discount_amount' => 10000,
            'status' => 'pending',
            'midtrans_order_id' => 'TRX-REG-' . time(),
        ]);

        $payload = [
            'order_id' => $transaction->midtrans_order_id,
            'status_code' => '200',
            'gross_amount' => '90000.00',
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
        ];

        $this->postJson('/api/midtrans-callback', $payload)->assertStatus(200);

        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'uses' => 1,
        ]);
        
        // Ensure NO commission is recorded
        $this->assertDatabaseCount('affiliate_commissions', 0);
    }
}
