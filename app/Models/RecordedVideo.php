<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedVideo extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'float',
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
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
}
