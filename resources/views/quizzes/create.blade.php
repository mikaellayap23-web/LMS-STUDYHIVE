<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Quiz - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .form-container {
            max-width: 800px;
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
            min-height: 120px;
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

        .alert-danger ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        .context-info {
            background: var(--green-pale);
            border: 1px solid var(--green-light);
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .context-info h3 {
            font-size: 0.875rem;
            color: var(--green-primary);
            margin-bottom: 0.5rem;
        }

        .context-info p {
            font-size: 0.9375rem;
            color: var(--gray-800);
            margin: 0;
        }

        .context-info span {
            color: var(--gray-600);
            font-size: 0.8125rem;
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
                <span>Create Quiz</span>
            </div>

            <div class="form-header">
                <h1><i class="fas fa-clipboard-question"></i> Create New Quiz</h1>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="context-info">
                <h3>Adding quiz to:</h3>
                <p>{{ $lesson->title }}</p>
                <span>{{ $module->module_title }} &bull; {{ $course->course_name }}</span>
            </div>

            <form action="{{ route('lessons.quizzes.store', $lesson) }}" method="POST" class="form-card">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="quiz_number">Quiz Number <span class="required">*</span></label>
                        <input type="text" id="quiz_number" name="quiz_number" value="{{ old('quiz_number', $nextQuizNumber) }}" required placeholder="e.g., Q-01">
                        <small>A unique identifier for this quiz</small>
                    </div>

                    <div class="form-group">
                        <label for="order">Display Order <span class="required">*</span></label>
                        <input type="number" id="order" name="order" value="{{ old('order', $nextOrder) }}" required min="0">
                        <small>Order in which quiz appears</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Enter the quiz title">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Provide a brief description of this quiz">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="instructions">Instructions</label>
                    <textarea id="instructions" name="instructions" placeholder="Enter instructions for students taking this quiz">{{ old('instructions') }}</textarea>
                    <small>These instructions will be shown before the quiz starts</small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="time_limit">Time Limit (minutes)</label>
                        <input type="number" id="time_limit" name="time_limit" value="{{ old('time_limit') }}" min="1" placeholder="Leave empty for no limit">
                        <small>Optional time limit for the quiz</small>
                    </div>

                    <div class="form-group">
                        <label for="passing_score">Passing Score (%) <span class="required">*</span></label>
                        <input type="number" id="passing_score" name="passing_score" value="{{ old('passing_score', 70) }}" required min="0" max="100">
                        <small>Minimum percentage to pass</small>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active">Active (visible to students)</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Create Quiz
                    </button>
                    <a href="{{ route('courses.modules.show', [$course, $module]) }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
