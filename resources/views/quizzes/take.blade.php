<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Taking Quiz: {{ $quiz->title }} - Studyhive</title>
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

        .quiz-header {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .quiz-header h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--green-primary);
            margin: 0;
        }

        .quiz-progress {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .progress-text {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .timer {
            background: var(--green-pale);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            color: var(--green-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .timer.warning {
            background: #fff3cd;
            color: #856404;
        }

        .timer.danger {
            background: #f8d7da;
            color: #721c24;
        }

        .question-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .question-number {
            background: var(--green-primary);
            color: var(--white);
            padding: 0.375rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .question-points {
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        .question-text {
            font-size: 1.125rem;
            color: var(--gray-800);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .options-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .option-item {
            position: relative;
        }

        .option-item input {
            position: absolute;
            opacity: 0;
        }

        .option-item label {
            display: block;
            padding: 1rem 1.25rem;
            padding-left: 3rem;
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 1rem;
            color: var(--gray-700);
        }

        .option-item label::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid var(--gray-300);
            border-radius: 50%;
            background: var(--white);
            transition: all 0.2s ease;
        }

        .option-item input:checked + label {
            border-color: var(--green-primary);
            background: var(--green-pale);
        }

        .option-item input:checked + label::before {
            border-color: var(--green-primary);
            background: var(--green-primary);
        }

        .option-item input:checked + label::after {
            content: '';
            position: absolute;
            left: 1.375rem;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--white);
        }

        .option-item label:hover {
            border-color: var(--green-light);
        }

        .short-answer-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        .short-answer-input:focus {
            outline: none;
            border-color: var(--green-primary);
        }

        .quiz-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
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

        .btn-submit {
            background: var(--green-primary);
            color: var(--white);
        }

        .btn-submit:hover {
            opacity: 0.85;
        }

        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        .questions-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .question-nav-item {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: var(--gray-200);
            color: var(--gray-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .question-nav-item:hover {
            background: var(--green-light);
            color: var(--white);
        }

        .question-nav-item.answered {
            background: var(--green-primary);
            color: var(--white);
        }

        .question-nav-item.current {
            border: 2px solid var(--green-primary);
        }
    </style>
</head>
<body>
    <x-sidebar active="modules" />

    <div class="main-content">
        <div class="quiz-container">
            <div class="quiz-header">
                <h1><i class="fas fa-clipboard-question"></i> {{ $quiz->title }}</h1>
                <div class="quiz-progress">
                    <span class="progress-text">{{ $quiz->questions->count() }} Questions</span>
                    @if($quiz->time_limit)
                        <div class="timer" id="timer">
                            <i class="fas fa-clock"></i>
                            <span id="timer-display">{{ $quiz->time_limit }}:00</span>
                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ route('quizzes.submit', ['quiz' => $quiz, 'attempt' => $attempt]) }}" method="POST" id="quiz-form">
                @csrf

                @foreach($quiz->questions as $index => $question)
                    <div class="question-card" id="question-{{ $index + 1 }}">
                        <div class="question-header">
                            <span class="question-number">Question {{ $index + 1 }}</span>
                            <span class="question-points">{{ $question->points }} point{{ $question->points > 1 ? 's' : '' }}</span>
                        </div>

                        <div class="question-text">{{ $question->question }}</div>

                        @if($question->question_type === 'multiple_choice')
                            <div class="options-list">
                                @foreach($question->options as $optionIndex => $option)
                                    <div class="option-item">
                                        <input type="radio"
                                               name="answers[{{ $question->id }}]"
                                               id="q{{ $question->id }}_opt{{ $optionIndex }}"
                                               value="{{ $option }}"
                                               onchange="markAnswered({{ $index + 1 }})">
                                        <label for="q{{ $question->id }}_opt{{ $optionIndex }}">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($question->question_type === 'true_false')
                            <div class="options-list">
                                <div class="option-item">
                                    <input type="radio"
                                           name="answers[{{ $question->id }}]"
                                           id="q{{ $question->id }}_true"
                                           value="True"
                                           onchange="markAnswered({{ $index + 1 }})">
                                    <label for="q{{ $question->id }}_true">True</label>
                                </div>
                                <div class="option-item">
                                    <input type="radio"
                                           name="answers[{{ $question->id }}]"
                                           id="q{{ $question->id }}_false"
                                           value="False"
                                           onchange="markAnswered({{ $index + 1 }})">
                                    <label for="q{{ $question->id }}_false">False</label>
                                </div>
                            </div>
                        @else
                            <input type="text"
                                   name="answers[{{ $question->id }}]"
                                   class="short-answer-input"
                                   placeholder="Type your answer here..."
                                   oninput="markAnswered({{ $index + 1 }})">
                        @endif
                    </div>
                @endforeach

                <div class="quiz-actions">
                    <div class="questions-nav">
                        @foreach($quiz->questions as $index => $question)
                            <a href="#question-{{ $index + 1 }}" class="question-nav-item" id="nav-{{ $index + 1 }}">
                                {{ $index + 1 }}
                            </a>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-submit" onclick="return confirm('Are you sure you want to submit your answers?')">
                        <i class="fas fa-paper-plane"></i> Submit Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function markAnswered(questionNum) {
            document.getElementById('nav-' + questionNum).classList.add('answered');
        }

        @if($quiz->time_limit)
        // Timer functionality
        const startTime = new Date('{{ $attempt->started_at }}').getTime();
        const timeLimit = {{ $quiz->time_limit }} * 60 * 1000; // Convert to milliseconds
        const timerDisplay = document.getElementById('timer-display');
        const timerContainer = document.getElementById('timer');

        function updateTimer() {
            const now = new Date().getTime();
            const elapsed = now - startTime;
            const remaining = timeLimit - elapsed;

            if (remaining <= 0) {
                document.getElementById('quiz-form').submit();
                return;
            }

            const minutes = Math.floor(remaining / (60 * 1000));
            const seconds = Math.floor((remaining % (60 * 1000)) / 1000);

            timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            // Warning at 5 minutes
            if (remaining <= 5 * 60 * 1000 && remaining > 1 * 60 * 1000) {
                timerContainer.classList.add('warning');
                timerContainer.classList.remove('danger');
            }
            // Danger at 1 minute
            else if (remaining <= 1 * 60 * 1000) {
                timerContainer.classList.remove('warning');
                timerContainer.classList.add('danger');
            }
        }

        updateTimer();
        setInterval(updateTimer, 1000);
        @endif
    </script>
</body>
</html>
