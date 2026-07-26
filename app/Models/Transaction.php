<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'user_id',
        'amount',
        'currency',
        'status',
        'item_type',
        'item_id',
        'metadata',
        'paystack_response',
        'failure_reason',
        'paid_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'paystack_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
