<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'module_id',
        'lesson_number',
        'title',
        'description',
        'content',
        'file_path',
        'original_filename',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Boot method for cascade delete.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($lesson) {
            $lesson->topics()->each(function ($topic) {
                $topic->delete();
            });
            $lesson->quizzes()->each(function ($quiz) {
                $quiz->delete();
            });
        });
    }

    /**
     * Get the module that owns the lesson.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the topics for the lesson.
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class)->orderBy('order');
    }

    /**
     * Get the quizzes for the lesson.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class)->orderBy('order');
    }

    /**
     * Scope for active lessons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered lessons.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Check if the lesson has any content.
     */
    public function getHasContentAttribute(): bool
    {
        return !empty($this->content) || $this->topics()->exists();
    }

    /**
     * Get the count of topics.
     */
    public function getTopicsCountAttribute(): int
    {
        return $this->topics()->count();
    }
}
