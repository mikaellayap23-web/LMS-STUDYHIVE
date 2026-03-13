<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_type',
        'question',
        'options',
        'correct_answer',
        'explanation',
        'points',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'points' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the quiz that owns the question.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Check if the given answer is correct.
     */
    public function isCorrect(string $answer): bool
    {
        if ($this->question_type === 'true_false') {
            return strtolower(trim($answer)) === strtolower(trim($this->correct_answer));
        }

        return trim($answer) === trim($this->correct_answer);
    }
}
