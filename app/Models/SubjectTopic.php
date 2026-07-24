<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTopic extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['creator'];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // public function live_class()
    // {
    //     return $this->belongsTo(LiveClass::class);
    // }
}
