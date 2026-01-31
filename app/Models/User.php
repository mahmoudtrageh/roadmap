<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'current_streak',
        'longest_streak',
        'last_activity_date',
        'daily_study_hours',
        'theme_preference',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_activity_date' => 'date',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isInstructor(): bool
    {
        return $this->role === 'instructor';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isCompany(): bool
    {
        return $this->role === 'company';
    }

    public function createdRoadmaps(): HasMany
    {
        return $this->hasMany(Roadmap::class, 'creator_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(RoadmapEnrollment::class, 'student_id');
    }

    public function taskCompletions(): HasMany
    {
        return $this->hasMany(TaskCompletion::class, 'student_id');
    }

    public function codeSubmissions(): HasMany
    {
        return $this->hasMany(CodeSubmission::class, 'student_id');
    }

    public function codeReviews(): HasMany
    {
        return $this->hasMany(CodeReview::class, 'reviewer_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function weeklyReviews(): HasMany
    {
        return $this->hasMany(WeeklyReview::class, 'student_id');
    }

    public function monthlyReviews(): HasMany
    {
        return $this->hasMany(MonthlyReview::class, 'student_id');
    }

    public function resourceRatings(): HasMany
    {
        return $this->hasMany(ResourceRating::class);
    }

    public function resourceComments(): HasMany
    {
        return $this->hasMany(ResourceComment::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'student_id');
    }
}
