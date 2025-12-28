<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'pair',
        'price',
        'amount',
        'value',
        'txid',
        'notes',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'price' => 'decimal:8',
        'amount' => 'decimal:8',
        'value' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
