<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'information_sheet_id',
        'topic_number',
        'title',
        'content',
        'file_path',
        'original_filename',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the information sheet that owns the topic.
     */
    public function informationSheet(): BelongsTo
    {
        return $this->belongsTo(InformationSheet::class);
    }

    /**
     * Get the next topic in sequence.
     */
    public function getNextTopic(): ?Topic
    {
        return static::where('information_sheet_id', $this->information_sheet_id)
            ->where('order', '>', $this->order)
            ->orderBy('order')
            ->first();
    }

    /**
     * Get the previous topic in sequence.
     */
    public function getPreviousTopic(): ?Topic
    {
        return static::where('information_sheet_id', $this->information_sheet_id)
            ->where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();
    }

    /**
     * Scope to order by the order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
