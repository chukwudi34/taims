<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'pricing';

    protected $casts = [
        'amount' => 'float',
        'is_active' => 'boolean',
    ];
}
