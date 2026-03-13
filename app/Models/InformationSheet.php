<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InformationSheet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'module_id',
        'sheet_number',
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
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Cascade soft delete to topics
        static::deleting(function ($sheet) {
            $sheet->topics()->each(function ($topic) {
                $topic->delete();
            });
        });
    }

    /**
     * Get the module that owns the information sheet.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the topics for the information sheet.
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class)->orderBy('order');
    }

    /**
     * Scope to filter active information sheets.
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
     * Check if the information sheet has any content.
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
