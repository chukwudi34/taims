<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $primaryKey = 'id';
    protected $with = ['userType'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id', 'id');
    }

    public function subject_topic()
    {
        return $this->hasMany(SubjectTopic::class);
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setFnameAttribute($value)
    {
        $this->attributes['fname'] = ucfirst(strtolower($value));
    }

    /**
     * Set the user's last name.
     *
     * @param  string  $value
     * @return void
     */
    public function setLnameAttribute($value)
    {
        $this->attributes['lname'] = ucfirst(strtolower($value));
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */

    public function setMnameAttribute($value)
    {
        $this->attributes['mname'] = ucfirst(strtolower($value));
    }

    /**
     * Set the user's email.
     *
     * @param  string  $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Boot the Model.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->id = Uuid::uuid4();
        });
    }
    public function optionQuestions()
    {
        return $this->hasMany(OptionQuestion::class);
    }

    public function questions()
    {
        return $this->hasManyThrough(Question::class, OptionQuestion::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function hasAccessToClass($classId): bool
    {
        return $this->transactions()
            ->where('item_type', 'class')
            ->where('item_id', $classId)
            ->where('status', 'completed')
            ->exists();
    }

    public function hasAccessToVideo($videoId): bool
    {
        return $this->transactions()
            ->where('item_type', 'video')
            ->where('item_id', $videoId)
            ->where('status', 'completed')
            ->exists();
    }

    public function hasAccessToLiveClass($liveClassId): bool
    {
        return $this->transactions()
            ->where('item_type', 'live_class')
            ->where('item_id', $liveClassId)
            ->where('status', 'completed')
            ->exists();
    }

    public function hasAccessToQuiz($quizId): bool
    {
        return $this->transactions()
            ->where('item_type', 'quiz')
            ->where('item_id', $quizId)
            ->where('status', 'completed')
            ->exists();
    }
}
