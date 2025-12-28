<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'user_id',
        'pair',
        'direction',
        'leverage',
        'margin',
        'entry_price',
        'exit_price',
        'pnl_value',
        'pnl_percentage',
        'status',
        'notes',
        'image_path',
        'trade_date',
    ];

    protected $casts = [
        'trade_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
