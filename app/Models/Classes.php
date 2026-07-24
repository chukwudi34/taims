<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classes extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function quiz_category(): HasMany
    {
        return $this->hasMany(QuizCategory::class,'class_id','id');
    }
}
