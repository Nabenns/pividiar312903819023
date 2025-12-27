<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'description',
        'content',
        'order',
        'is_free',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_free' => 'boolean',
        ];
    }
}
