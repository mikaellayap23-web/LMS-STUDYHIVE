<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Quiz - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .form-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .form-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-200);
        }

        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--green-primary);
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

        .form-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
            font-size: 0.9375rem;
        }

        .form-group label .required {
            color: #e74c3c;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            font-size: 0.9375rem;
            font-family: inherit;
            transition: border-color 0.2s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--green-light);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group small {
            display: block;
            margin-top: 0.375rem;
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--green-primary);
        }

        .checkbox-group label {
            margin-bottom: 0;
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-200);
        }

        .btn-submit {
            background: var(--green-primary);
            color: var(--white);
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: background 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-submit:hover {
            background: var(--green-secondary);
        }

        .btn-cancel {
            background: var(--gray-200);
            color: var(--gray-800);
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9375rem;
            text-decoration: none;
            transition: background 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-cancel:hover {
            background: var(--gray-400);
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--green-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .questions-list {
            margin-bottom: 2rem;
        }

        .question-item {
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .question-number {
            background: var(--green-primary);
            color: var(--white);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .question-type {
            font-size: 0.75rem;
            color: var(--gray-500);
            text-transform: uppercase;
        }

        .question-text {
            font-size: 1rem;
            color: var(--gray-800);
            margin-bottom: 0.75rem;
        }

        .question-options {
            padding-left: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .question-options li {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .question-options li.correct {
            color: var(--green-primary);
            font-weight: 600;
        }

        .question-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8125rem;
            color: var(--gray-500);
            padding-top: 0.75rem;
            border-top: 1px solid var(--gray-200);
        }

        .btn-delete-question {
            background: #e74c3c;
            color: var(--white);
            padding: 0.375rem 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 0.8125rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-delete-question:hover {
            background: #c0392b;
        }

        .add-question-form {
            background: var(--green-pale);
            border: 1px solid var(--green-light);
            border-radius: 8px;
            padding: 1.5rem;
        }

        .options-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .option-input {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .option-input input {
            flex: 1;
        }

        .option-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            min-width: 80px;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--gray-500);
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--gray-400);
        }
    </style>
</head>
<body>
    <x-sidebar active="modules" />

    <div class="main-content">
        <div class="form-container">
            <div class="breadcrumb">
                <a href="{{ route('courses.index') }}">Courses</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('courses.show', $course) }}">{{ $course->course_code }}</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('courses.modules.show', [$course, $module]) }}">{{ $module->module_number }}</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('quizzes.show', $quiz) }}">{{ $quiz->quiz_number }}</a>
                <i class="fas fa-chevron-right"></i>
                <span>Edit</span>
            </div>

            <div class="form-header">
                <h1><i class="fas fa-edit"></i> Edit Quiz</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('quizzes.update', $quiz) }}" method="POST" class="form-card">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label for="quiz_number">Quiz Number <span class="required">*</span></label>
                        <input type="text" id="quiz_number" name="quiz_number" value="{{ old('quiz_number', $quiz->quiz_number) }}" required placeholder="e.g., Q-01">
                    </div>

                    <div class="form-group">
                        <label for="order">Display Order <span class="required">*</span></label>
                        <input type="number" id="order" name="order" value="{{ old('order', $quiz->order) }}" required min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $quiz->title) }}" required placeholder="Enter the quiz title">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Provide a brief description of this quiz">{{ old('description', $quiz->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="instructions">Instructions</label>
                    <textarea id="instructions" name="instructions" placeholder="Enter instructions for students taking this quiz">{{ old('instructions', $quiz->instructions) }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="time_limit">Time Limit (minutes)</label>
                        <input type="number" id="time_limit" name="time_limit" value="{{ old('time_limit', $quiz->time_limit) }}" min="1" placeholder="Leave empty for no limit">
                    </div>

                    <div class="form-group">
                        <label for="passing_score">Passing Score (%) <span class="required">*</span></label>
                        <input type="number" id="passing_score" name="passing_score" value="{{ old('passing_score', $quiz->passing_score) }}" required min="0" max="100">
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $quiz->is_active) ? 'checked' : '' }}>
                        <label for="is_active">Active (visible to students)</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Update Quiz
                    </button>
                    <a href="{{ route('quizzes.show', $quiz) }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>

            <!-- Questions Section -->
            <h2 class="section-title"><i class="fas fa-list-ol"></i> Questions ({{ $quiz->questions->count() }})</h2>

            <div class="questions-list">
                @if($quiz->questions->count() > 0)
                    @foreach($quiz->questions as $index => $question)
                        <div class="question-item">
                            <div class="question-header">
                                <span class="question-number">Q{{ $index + 1 }}</span>
                                <span class="question-type">
                                    @if($question->question_type === 'multiple_choice')
                                        Multiple Choice
                                    @elseif($question->question_type === 'true_false')
                                        True/False
                                    @else
                                        Short Answer
                                    @endif
                                </span>
                            </div>
                            <div class="question-text">{{ $question->question }}</div>
                            @if($question->question_type === 'multiple_choice' && $question->options)
                                <ul class="question-options">
                                    @foreach($question->options as $option)
                                        <li class="{{ $option === $question->correct_answer ? 'correct' : '' }}">
                                            {{ $option }}
                                            @if($option === $question->correct_answer)
                                                <i class="fas fa-check"></i>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif($question->question_type === 'true_false')
                                <p style="font-size: 0.875rem; color: var(--green-primary);">
                                    <strong>Correct Answer:</strong> {{ $question->correct_answer }}
                                </p>
                            @else
                                <p style="font-size: 0.875rem; color: var(--green-primary);">
                                    <strong>Correct Answer:</strong> {{ $question->correct_answer }}
                                </p>
                            @endif
                            @if($question->explanation)
                                <p style="font-size: 0.8125rem; color: var(--gray-600); font-style: italic; margin-top: 0.5rem;">
                                    <i class="fas fa-info-circle"></i> {{ $question->explanation }}
                                </p>
                            @endif
                            <div class="question-meta">
                                <span>{{ $question->points }} point{{ $question->points > 1 ? 's' : '' }}</span>
                                <form action="{{ route('quizzes.questions.destroy', [$quiz, $question->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this question?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-question">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-question-circle"></i>
                        <p>No questions added yet. Add your first question below.</p>
                    </div>
                @endif
            </div>

            <!-- Add Question Form -->
            <div class="form-card add-question-form">
                <h3 class="section-title"><i class="fas fa-plus-circle"></i> Add New Question</h3>

                <form action="{{ route('quizzes.questions.store', $quiz) }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="question_type">Question Type <span class="required">*</span></label>
                            <select id="question_type" name="question_type" required onchange="toggleQuestionOptions(this.value)">
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="true_false">True/False</option>
                                <option value="short_answer">Short Answer</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="points">Points <span class="required">*</span></label>
                            <input type="number" id="points" name="points" value="1" required min="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="question">Question <span class="required">*</span></label>
                        <textarea id="question" name="question" required placeholder="Enter your question here"></textarea>
                    </div>

                    <div id="options-container" class="form-group">
                        <label>Options <span class="required">*</span></label>
                        <div class="options-group">
                            <div class="option-input">
                                <span class="option-label">Option A:</span>
                                <input type="text" name="options[]" placeholder="Enter option A">
                            </div>
                            <div class="option-input">
                                <span class="option-label">Option B:</span>
                                <input type="text" name="options[]" placeholder="Enter option B">
                            </div>
                            <div class="option-input">
                                <span class="option-label">Option C:</span>
                                <input type="text" name="options[]" placeholder="Enter option C">
                            </div>
                            <div class="option-input">
                                <span class="option-label">Option D:</span>
                                <input type="text" name="options[]" placeholder="Enter option D">
                            </div>
                        </div>
                        <small>Leave empty options blank if not needed</small>
                    </div>

                    <div id="truefalse-container" class="form-group" style="display: none;">
                        <label>Correct Answer <span class="required">*</span></label>
                        <select name="correct_answer_tf">
                            <option value="True">True</option>
                            <option value="False">False</option>
                        </select>
                    </div>

                    <div id="correct-answer-mc" class="form-group">
                        <label for="correct_answer">Correct Answer <span class="required">*</span></label>
                        <input type="text" id="correct_answer" name="correct_answer" placeholder="Enter the correct answer (must match one of the options exactly)">
                        <small>For multiple choice, this must exactly match one of the options above</small>
                    </div>

                    <div class="form-group">
                        <label for="explanation">Explanation (Optional)</label>
                        <textarea id="explanation" name="explanation" placeholder="Explain why this is the correct answer"></textarea>
                        <small>This will be shown to students after they submit their answer</small>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-plus"></i> Add Question
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleQuestionOptions(type) {
            const optionsContainer = document.getElementById('options-container');
            const trueFalseContainer = document.getElementById('truefalse-container');
            const correctAnswerMc = document.getElementById('correct-answer-mc');

            if (type === 'multiple_choice') {
                optionsContainer.style.display = 'block';
                trueFalseContainer.style.display = 'none';
                correctAnswerMc.style.display = 'block';
            } else if (type === 'true_false') {
                optionsContainer.style.display = 'none';
                trueFalseContainer.style.display = 'block';
                correctAnswerMc.style.display = 'none';
            } else {
                optionsContainer.style.display = 'none';
                trueFalseContainer.style.display = 'none';
                correctAnswerMc.style.display = 'block';
            }
        }
    </script>
</body>
</html>
