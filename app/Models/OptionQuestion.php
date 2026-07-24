<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionQuestion extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'option_questions';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function options()
    {
        return $this->belongsTo(Option::class,'option_id','id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

}
