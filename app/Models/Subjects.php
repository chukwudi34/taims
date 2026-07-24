<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Subjects extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
