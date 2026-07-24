<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function optionQuestions()
    {
        return $this->hasMany(OptionQuestion::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    // public function options()
    // {
    //     return $this->hasMany(Option::class);
    // }

    // public function quiz(): BelongsTo
    // {
    //     return $this->belongsTo(Quiz::class);
    // }
}
