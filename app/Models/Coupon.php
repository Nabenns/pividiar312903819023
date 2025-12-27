<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_amount',
        'max_uses',
        'uses',
        'expires_at',
        'affiliate_user_id',
        'commission_type',
        'commission_amount',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function affiliate()
    {
        return $this->belongsTo(User::class, 'affiliate_user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses && $this->uses >= $this->max_uses) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($total)
    {
        if ($this->discount_type === 'fixed') {
            return min($this->discount_amount, $total);
        }

        return $total * ($this->discount_amount / 100);
    }

    public function calculateCommission($total)
    {
        if ($this->commission_type === 'fixed') {
            return $this->commission_amount;
        }

        return $total * ($this->commission_amount / 100);
    }
}
