<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LiveClass extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casted = [
        "participants" => "array",
    ];
    protected $with = ['subject', 'topic', 'creator'];

    public function subject()
    {
        return $this->belongsTo(Subjects::class, 'subject_id', 'id');
    }

    public function topic()
    {
        return $this->belongsTo(SubjectTopic::class, 'topic_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function quiz_category(): BelongsTo
    {
        return $this->belongsTo(QuizCategory::class);
    }
}
