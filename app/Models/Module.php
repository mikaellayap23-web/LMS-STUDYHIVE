<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Module extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id',
        'module_title',
        'module_number',
        'slug',
        'description',
        'learning_outcomes',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug on creating
        static::creating(function ($module) {
            if (empty($module->slug)) {
                $module->slug = static::generateUniqueSlug($module->module_title, $module->course_id);
            }
        });

        // Auto-generate slug on updating if title changed
        static::updating(function ($module) {
            if ($module->isDirty('module_title') && empty($module->slug)) {
                $module->slug = static::generateUniqueSlug($module->module_title, $module->course_id, $module->id);
            }
        });

        // Cascade soft delete to lessons
        static::deleting(function ($module) {
            $module->lessons()->each(function ($lesson) {
                $lesson->delete();
            });
        });
    }

    /**
     * Generate a unique slug for the module within its course.
     */
    protected static function generateUniqueSlug(string $title, int $courseId, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('course_id', $courseId)
            ->where('slug', $slug)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Get the course that owns the module.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lessons for the module.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    /**
     * Get the active lessons for the module.
     */
    public function activeLessons(): HasMany
    {
        return $this->hasMany(Lesson::class)
            ->where('is_active', true)
            ->orderBy('order');
    }

    /**
     * Scope to filter active modules.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by the order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
