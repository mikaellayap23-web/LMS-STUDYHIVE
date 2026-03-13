<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $quiz->title }} - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .quiz-container {
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

        .quiz-header {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .quiz-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .quiz-meta {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-number {
            background: var(--green-pale);
            color: var(--green-primary);
        }

        .badge-active {
            background: #d4edda;
            color: #155724;
        }

        .badge-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .quiz-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: opacity 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--green-primary);
            color: var(--white);
        }

        .btn-secondary {
            background: var(--green-light);
            color: var(--white);
        }

        .btn-danger {
            background: #e74c3c;
            color: var(--white);
        }

        .btn:hover {
            opacity: 0.85;
        }

        .quiz-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0.5rem 0;
        }

        .quiz-description {
            color: var(--gray-600);
            line-height: 1.6;
            margin-top: 0.75rem;
        }

        .quiz-info {
            display: flex;
            gap: 1.5rem;
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
            flex-wrap: wrap;
        }

        .quiz-info span {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .quiz-info i {
            color: var(--green-light);
        }

        .quiz-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .quiz-card h2 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--green-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .instructions {
            background: var(--green-pale);
            border-left: 4px solid var(--green-primary);
            padding: 1rem 1.25rem;
            border-radius: 0 6px 6px 0;
            margin-bottom: 1.5rem;
        }

        .instructions p {
            color: var(--gray-700);
            line-height: 1.6;
            margin: 0;
            white-space: pre-wrap;
        }

        .start-quiz-section {
            text-align: center;
            padding: 2rem;
        }

        .start-quiz-section .btn-primary {
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
        }

        .attempts-list {
            margin-top: 1rem;
        }

        .attempt-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: var(--gray-100);
            border-radius: 6px;
            margin-bottom: 0.75rem;
        }

        .attempt-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .attempt-date {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .attempt-score {
            font-size: 1.125rem;
            font-weight: 600;
        }

        .attempt-score.passed {
            color: var(--green-primary);
        }

        .attempt-score.failed {
            color: #e74c3c;
        }

        .attempt-actions a {
            color: var(--green-primary);
            text-decoration: none;
            font-size: 0.875rem;
        }

        .attempt-actions a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--gray-500);
        }

        .empty-state i {
            font-size: 2rem;
            margin-bottom: 0.75rem;
            color: var(--gray-400);
        }
    </style>
</head>
<body>
    <x-sidebar active="modules" />

    <div class="main-content">
        <div class="quiz-container">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="breadcrumb">
                <a href="{{ route('courses.index') }}">Courses</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('courses.show', $course) }}">{{ $course->course_code }}</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('courses.modules.show', [$course, $module]) }}">{{ $module->module_number }}</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $quiz->quiz_number }}</span>
            </div>

            <div class="quiz-header">
                <div class="quiz-header-top">
                    <div class="quiz-meta">
                        <span class="badge badge-number">{{ $quiz->quiz_number }}</span>
                        <span class="badge {{ $quiz->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                        <div class="quiz-actions">
                            <a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <h1 class="quiz-title">{{ $quiz->title }}</h1>

                @if($quiz->description)
                    <p class="quiz-description">{{ $quiz->description }}</p>
                @endif

                <div class="quiz-info">
                    <span><i class="fas fa-book-open"></i> {{ $lesson->title }}</span>
                    <span><i class="fas fa-question-circle"></i> {{ $quiz->questions->count() }} Questions</span>
                    <span><i class="fas fa-star"></i> {{ $quiz->total_points }} Points</span>
                    @if($quiz->time_limit)
                        <span><i class="fas fa-clock"></i> {{ $quiz->time_limit }} minutes</span>
                    @endif
                    <span><i class="fas fa-percent"></i> {{ $quiz->passing_score }}% to pass</span>
                </div>
            </div>

            @if($quiz->instructions)
                <div class="quiz-card">
                    <h2><i class="fas fa-info-circle"></i> Instructions</h2>
                    <div class="instructions">
                        <p>{{ $quiz->instructions }}</p>
                    </div>
                </div>
            @endif

            @if($quiz->is_active && $quiz->questions->count() > 0)
                <div class="quiz-card">
                    <div class="start-quiz-section">
                        <form action="{{ route('quizzes.start', $quiz) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-play"></i> Start Quiz
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($quiz->questions->count() === 0)
                <div class="quiz-card">
                    <div class="empty-state">
                        <i class="fas fa-question-circle"></i>
                        <p>This quiz has no questions yet.</p>
                        @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                            <p><a href="{{ route('quizzes.edit', $quiz) }}">Add questions to this quiz</a></p>
                        @endif
                    </div>
                </div>
            @endif

            @if($attempts->count() > 0)
                <div class="quiz-card">
                    <h2><i class="fas fa-history"></i> Your Attempts</h2>
                    <div class="attempts-list">
                        @foreach($attempts as $attempt)
                            <div class="attempt-item">
                                <div class="attempt-info">
                                    <span class="attempt-date">
                                        {{ $attempt->created_at->format('M d, Y h:i A') }}
                                    </span>
                                    @if($attempt->completed_at)
                                        <span class="attempt-score {{ $attempt->passed ? 'passed' : 'failed' }}">
                                            {{ number_format($attempt->percentage, 1) }}% ({{ $attempt->score }}/{{ $attempt->total_points }} points)
                                            @if($attempt->passed)
                                                <i class="fas fa-check-circle"></i> Passed
                                            @else
                                                <i class="fas fa-times-circle"></i> Failed
                                            @endif
                                        </span>
                                    @else
                                        <span class="attempt-score" style="color: var(--gray-500);">
                                            <i class="fas fa-spinner"></i> In Progress
                                        </span>
                                    @endif
                                </div>
                                <div class="attempt-actions">
                                    @if($attempt->completed_at)
                                        <a href="{{ route('quizzes.result', ['quiz' => $quiz, 'attempt' => $attempt]) }}">
                                            <i class="fas fa-eye"></i> View Results
                                        </a>
                                    @else
                                        <a href="{{ route('quizzes.take', ['quiz' => $quiz, 'attempt' => $attempt]) }}">
                                            <i class="fas fa-play"></i> Continue
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
