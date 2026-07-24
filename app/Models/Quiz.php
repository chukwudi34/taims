<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function quiz_category(): BelongsTo
    {
        return $this->belongsTo(QuizCategory::class,'category_id','id');
    }

    public function question(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
