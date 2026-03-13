<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lesson_id',
        'quiz_number',
        'title',
        'description',
        'instructions',
        'time_limit',
        'passing_score',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'time_limit' => 'integer',
        'passing_score' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Boot method for cascade delete.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($quiz) {
            $quiz->questions()->delete();
            $quiz->attempts()->delete();
        });
    }

    /**
     * Get the lesson that owns the quiz.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the questions for the quiz.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    /**
     * Get the attempts for the quiz.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Scope for active quizzes.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered quizzes.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get the total points for the quiz.
     */
    public function getTotalPointsAttribute(): int
    {
        return $this->questions()->sum('points');
    }

    /**
     * Get the question count.
     */
    public function getQuestionCountAttribute(): int
    {
        return $this->questions()->count();
    }
}
