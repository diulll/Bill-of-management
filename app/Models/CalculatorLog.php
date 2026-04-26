<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculatorLog extends Model
{
    protected $fillable = [
        'name',
        'shift',
        'log_date',
        'menus_data',
        'ingredients_data',
        'user_id',
    ];

    protected $casts = [
        'log_date'         => 'date',
        'menus_data'       => 'array',
        'ingredients_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
