<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizCategory extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function quiz(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subjects::class);
    }
    public function topic(): BelongsTo
    {
        return $this->belongsTo(SubjectTopic::class);
    }
}
