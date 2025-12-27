<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\AffiliateCommissionResource;
use App\Models\AffiliateCommission;
use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AffiliateCommissionResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'member']);
    }

    public function test_admin_can_list_affiliate_commissions()
    {
        // Create Admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Create Affiliate & Data
        $affiliate = User::factory()->create(['name' => 'Affiliate User']);
        $coupon = Coupon::create([
            'code' => 'TESTCOUPON',
            'discount_type' => 'percent',
            'discount_amount' => 10,
            'affiliate_user_id' => $affiliate->id,
            'commission_type' => 'percent',
            'commission_amount' => 20,
        ]);

        $plan = Plan::create([
            'name' => 'Test Plan',
            'slug' => 'test-plan',
            'price' => 100000,
            'billing_cycle' => 'monthly',
            'features' => []
        ]);

        $transaction = Transaction::create([
            'user_id' => User::factory()->create()->id,
            'plan_id' => $plan->id,
            'amount' => 90000,
            'subtotal' => 100000,
            'discount_amount' => 10000,
            'coupon_id' => $coupon->id,
            'status' => 'paid',
            'midtrans_order_id' => 'TRX-TEST-1',
        ]);

        $commission = AffiliateCommission::create([
            'affiliate_user_id' => $affiliate->id,
            'transaction_id' => $transaction->id,
            'amount' => 20000,
            'status' => 'pending',
        ]);

        // Act & Assert
        $this->actingAs($admin);
        
        Livewire::test(AffiliateCommissionResource\Pages\ListAffiliateCommissions::class)
            ->assertCanSeeTableRecords([$commission])
            ->assertSee('Affiliate User');
    }

    public function test_admin_can_mark_commission_as_paid()
    {
        // Create Admin
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Create Commission
        $affiliate = User::factory()->create();
        $transaction = Transaction::create([
            'user_id' => User::factory()->create()->id,
            'plan_id' => Plan::create(['name' => 'P', 'slug' => 'p', 'price' => 100, 'billing_cycle' => 'm', 'features' => []])->id,
            'amount' => 100,
            'subtotal' => 100,
            'discount_amount' => 0,
            'status' => 'paid',
            'midtrans_order_id' => 'TRX-TEST-2',
        ]);

        $commission = AffiliateCommission::create([
            'affiliate_user_id' => $affiliate->id,
            'transaction_id' => $transaction->id,
            'amount' => 50000,
            'status' => 'pending',
        ]);

        // Act
        $this->actingAs($admin);

        Livewire::test(AffiliateCommissionResource\Pages\ListAffiliateCommissions::class)
            ->callTableAction('mark_as_paid', $commission);

        // Assert
        $this->assertDatabaseHas('affiliate_commissions', [
            'id' => $commission->id,
            'status' => 'paid',
        ]);
    }
}
