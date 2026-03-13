<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz Results: {{ $quiz->title }} - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .result-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: var(--green-primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .result-header {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .result-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2.5rem;
        }

        .result-icon.passed {
            background: #d4edda;
            color: #28a745;
        }

        .result-icon.failed {
            background: #f8d7da;
            color: #dc3545;
        }

        .result-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .result-title.passed {
            color: #28a745;
        }

        .result-title.failed {
            color: #dc3545;
        }

        .result-subtitle {
            color: var(--gray-600);
            font-size: 1rem;
        }

        .score-card {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-200);
        }

        .score-item {
            text-align: center;
        }

        .score-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--green-primary);
        }

        .score-label {
            font-size: 0.875rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .result-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .result-card h2 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--green-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .question-result {
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .question-result.correct {
            border-left: 4px solid #28a745;
            background: #f8fff8;
        }

        .question-result.incorrect {
            border-left: 4px solid #dc3545;
            background: #fff8f8;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .question-number {
            font-weight: 600;
            color: var(--gray-700);
        }

        .question-status {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .question-status.correct {
            color: #28a745;
        }

        .question-status.incorrect {
            color: #dc3545;
        }

        .question-text {
            color: var(--gray-800);
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .answer-section {
            font-size: 0.9375rem;
        }

        .answer-row {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .answer-label {
            color: var(--gray-500);
            min-width: 110px;
        }

        .answer-value {
            color: var(--gray-800);
        }

        .answer-value.correct {
            color: #28a745;
            font-weight: 500;
        }

        .answer-value.incorrect {
            color: #dc3545;
            text-decoration: line-through;
        }

        .explanation {
            background: var(--green-pale);
            border-left: 3px solid var(--green-primary);
            padding: 0.75rem 1rem;
            margin-top: 1rem;
            border-radius: 0 6px 6px 0;
            font-size: 0.875rem;
            color: var(--gray-700);
        }

        .explanation strong {
            color: var(--green-primary);
        }

        .result-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--green-primary);
            color: var(--white);
        }

        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        .btn:hover {
            opacity: 0.85;
        }
    </style>
</head>
<body>
    <x-sidebar active="modules" />

    <div class="main-content">
        <div class="result-container">
            <div class="breadcrumb">
                <a href="{{ route('courses.index') }}">Courses</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('courses.show', $course) }}">{{ $course->course_code }}</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('courses.modules.show', [$course, $module]) }}">{{ $module->module_number }}</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('quizzes.show', $quiz) }}">{{ $quiz->quiz_number }}</a>
                <i class="fas fa-chevron-right"></i>
                <span>Results</span>
            </div>

            <div class="result-header">
                <div class="result-icon {{ $attempt->passed ? 'passed' : 'failed' }}">
                    <i class="fas {{ $attempt->passed ? 'fa-check' : 'fa-times' }}"></i>
                </div>
                <h1 class="result-title {{ $attempt->passed ? 'passed' : 'failed' }}">
                    {{ $attempt->passed ? 'Congratulations!' : 'Keep Practicing!' }}
                </h1>
                <p class="result-subtitle">
                    @if($attempt->passed)
                        You passed the quiz with a score of {{ number_format($attempt->percentage, 1) }}%
                    @else
                        You scored {{ number_format($attempt->percentage, 1) }}%. The passing score is {{ $quiz->passing_score }}%
                    @endif
                </p>

                <div class="score-card">
                    <div class="score-item">
                        <div class="score-value">{{ number_format($attempt->percentage, 1) }}%</div>
                        <div class="score-label">Score</div>
                    </div>
                    <div class="score-item">
                        <div class="score-value">{{ $attempt->score }}/{{ $attempt->total_points }}</div>
                        <div class="score-label">Points</div>
                    </div>
                    <div class="score-item">
                        @php
                            $correctCount = 0;
                            foreach ($quiz->questions as $question) {
                                $userAnswer = $attempt->answers[$question->id] ?? '';
                                if ($question->isCorrect($userAnswer)) {
                                    $correctCount++;
                                }
                            }
                        @endphp
                        <div class="score-value">{{ $correctCount }}/{{ $quiz->questions->count() }}</div>
                        <div class="score-label">Correct</div>
                    </div>
                </div>
            </div>

            <div class="result-card">
                <h2><i class="fas fa-list-check"></i> Question Review</h2>

                @foreach($quiz->questions as $index => $question)
                    @php
                        $userAnswer = $attempt->answers[$question->id] ?? '';
                        $isCorrect = $question->isCorrect($userAnswer);
                    @endphp
                    <div class="question-result {{ $isCorrect ? 'correct' : 'incorrect' }}">
                        <div class="question-header">
                            <span class="question-number">Question {{ $index + 1 }}</span>
                            <span class="question-status {{ $isCorrect ? 'correct' : 'incorrect' }}">
                                @if($isCorrect)
                                    <i class="fas fa-check-circle"></i> Correct (+{{ $question->points }} pts)
                                @else
                                    <i class="fas fa-times-circle"></i> Incorrect
                                @endif
                            </span>
                        </div>

                        <div class="question-text">{{ $question->question }}</div>

                        <div class="answer-section">
                            <div class="answer-row">
                                <span class="answer-label">Your answer:</span>
                                <span class="answer-value {{ $isCorrect ? 'correct' : 'incorrect' }}">
                                    {{ $userAnswer ?: '(No answer)' }}
                                </span>
                            </div>
                            @if(!$isCorrect)
                                <div class="answer-row">
                                    <span class="answer-label">Correct answer:</span>
                                    <span class="answer-value correct">{{ $question->correct_answer }}</span>
                                </div>
                            @endif
                        </div>

                        @if($question->explanation)
                            <div class="explanation">
                                <strong><i class="fas fa-lightbulb"></i> Explanation:</strong> {{ $question->explanation }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="result-actions">
                <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-primary">
                    <i class="fas fa-redo"></i> Try Again
                </a>
                <a href="{{ route('courses.modules.show', [$course, $module]) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Module
                </a>
            </div>
        </div>
    </div>
</body>
</html>
