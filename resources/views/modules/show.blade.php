<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $module->module_title }} - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .module-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: var(--green-primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Module Header Card */
        .module-header {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .module-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .module-meta-badges {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
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

        .badge-status {
            background: #d4edda;
            color: #155724;
        }

        .badge-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .module-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
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
            transition: all 0.2s ease;
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

        .btn-outline {
            background: transparent;
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
        }

        .btn-outline:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        .module-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0.5rem 0 1rem;
            line-height: 1.3;
        }

        /* Progress Bar */
        .progress-section {
            background: var(--gray-100);
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .progress-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .progress-label i {
            color: var(--green-primary);
        }

        .progress-stats {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .progress-bar-container {
            height: 10px;
            background: var(--gray-300);
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--green-primary), var(--green-light));
            border-radius: 5px;
            transition: width 0.5s ease;
        }

        /* Module Description */
        .module-description {
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: 1rem;
        }

        /* Learning Outcomes */
        .learning-outcomes {
            background: linear-gradient(135deg, var(--green-pale) 0%, #e8f5e9 100%);
            border-radius: 8px;
            padding: 1.25rem;
            border-left: 4px solid var(--green-primary);
        }

        .learning-outcomes h4 {
            font-size: 0.9375rem;
            color: var(--green-primary);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .learning-outcomes p {
            color: var(--gray-700);
            line-height: 1.8;
            white-space: pre-line;
            margin: 0;
        }

        /* Table of Contents Section */
        .toc-section {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .toc-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, var(--green-pale) 0%, #e8f5e9 100%);
            border-bottom: 1px solid var(--gray-200);
        }

        .toc-header h2 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--green-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }

        .toc-list {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        /* Lesson Accordion Item */
        .lesson-accordion {
            border-bottom: 1px solid var(--gray-200);
        }

        .lesson-accordion:last-child {
            border-bottom: none;
        }

        .lesson-accordion-header {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            background: var(--white);
            cursor: pointer;
            transition: background 0.2s ease;
            gap: 1rem;
        }

        .lesson-accordion-header:hover {
            background: var(--gray-50);
        }

        .lesson-accordion.locked .lesson-accordion-header {
            cursor: not-allowed;
            opacity: 0.7;
        }

        .lesson-accordion.locked .lesson-accordion-header:hover {
            background: var(--white);
        }

        .lesson-status-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.875rem;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-unlocked {
            background: var(--green-pale);
            color: var(--green-primary);
        }

        .status-locked {
            background: var(--gray-200);
            color: var(--gray-500);
        }

        .lesson-info {
            flex: 1;
            min-width: 0;
        }

        .lesson-number {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .lesson-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .lesson-accordion.locked .lesson-title {
            color: var(--gray-500);
        }

        .accordion-toggle {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            transition: transform 0.2s ease;
        }

        .lesson-accordion.open .accordion-toggle {
            transform: rotate(180deg);
        }

        .lesson-accordion.locked .accordion-toggle {
            display: none;
        }

        /* Accordion Content */
        .lesson-accordion-content {
            display: none;
            padding: 0 1.5rem 1rem 4.5rem;
        }

        .lesson-accordion.open .lesson-accordion-content {
            display: block;
        }

        .lesson-description {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        /* Content Items List */
        .content-items {
            background: var(--gray-50);
            border-radius: 8px;
            padding: 0.75rem;
        }

        .content-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            transition: background 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .content-item:hover {
            background: var(--white);
        }

        .content-item-icon {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-size: 0.75rem;
        }

        .content-item-icon.topic-icon {
            background: var(--green-pale);
            color: var(--green-primary);
        }

        .content-item-icon.quiz-icon {
            background: #e3f2fd;
            color: #1976d2;
        }

        .content-item-icon.quiz-icon.required {
            background: #fff3e0;
            color: #f57c00;
        }

        .content-item-text {
            flex: 1;
            font-size: 0.875rem;
            color: var(--gray-800);
        }

        .content-item-badge {
            font-size: 0.6875rem;
            font-weight: 600;
            padding: 0.125rem 0.5rem;
            border-radius: 10px;
            background: #fff3e0;
            color: #f57c00;
            text-transform: uppercase;
        }

        .content-item-badge.passed {
            background: #d4edda;
            color: #155724;
        }

        /* Empty State */
        .empty-lessons {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--gray-600);
        }

        .empty-lessons i {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: 1rem;
        }

        .empty-lessons h3 {
            font-size: 1.125rem;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        /* Module Navigation */
        .module-navigation {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .nav-link {
            flex: 1;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            border-color: var(--green-light);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .nav-link.nav-prev {
            text-align: left;
        }

        .nav-link.nav-next {
            text-align: right;
        }

        .nav-direction {
            font-size: 0.75rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.375rem;
        }

        .nav-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--green-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-prev .nav-title {
            justify-content: flex-start;
        }

        .nav-next .nav-title {
            justify-content: flex-end;
        }

        .nav-placeholder {
            flex: 1;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
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

        /* Locked Message */
        .locked-message {
            font-size: 0.8125rem;
            color: var(--gray-500);
            font-style: italic;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .module-container {
                padding: 1rem;
            }

            .module-header {
                padding: 1.5rem;
            }

            .module-title {
                font-size: 1.5rem;
            }

            .toc-header {
                padding: 1rem;
            }

            .lesson-accordion-header {
                padding: 1rem;
            }

            .lesson-accordion-content {
                padding: 0 1rem 1rem 3.5rem;
            }

            .module-navigation {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <x-sidebar active="modules" />

    <div class="main-content">
        <div class="module-container">
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

            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('courses.index') }}">Courses</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('courses.show', $course) }}">{{ $course->course_code }}</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $module->module_number }}</span>
            </div>

            <!-- Module Header -->
            <div class="module-header">
                <div class="module-header-top">
                    <div class="module-meta-badges">
                        <span class="badge badge-number">{{ $module->module_number }}</span>
                        <span class="badge {{ $module->is_active ? 'badge-status' : 'badge-inactive' }}">
                            {{ $module->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                        <div class="module-actions">
                            <a href="{{ route('courses.modules.lessons.create', [$course, $module]) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add Lesson
                            </a>
                            <a href="{{ route('courses.modules.edit', [$course, $module]) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('courses.modules.destroy', [$course, $module]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this module and all its content?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <h1 class="module-title">{{ $module->module_title }}</h1>

                <!-- Progress Bar -->
                @if($totalLessons > 0)
                    <div class="progress-section">
                        <div class="progress-header">
                            <span class="progress-label">
                                <i class="fas fa-chart-line"></i> Your Progress
                            </span>
                            <span class="progress-stats">{{ $completedLessons }} of {{ $totalLessons }} lessons completed</span>
                        </div>
                        <div class="progress-bar-container">
                            <div class="progress-bar-fill" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>
                @endif

                @if($module->description)
                    <p class="module-description">{{ $module->description }}</p>
                @endif

                @if($module->learning_outcomes)
                    <div class="learning-outcomes">
                        <h4><i class="fas fa-bullseye"></i> Learning Outcomes</h4>
                        <p>{{ $module->learning_outcomes }}</p>
                    </div>
                @endif
            </div>

            <!-- Table of Contents -->
            <div class="toc-section">
                <div class="toc-header">
                    <h2><i class="fas fa-list-ul"></i> Table of Contents</h2>
                </div>

                @if($module->lessons->count() > 0)
                    <ul class="toc-list">
                        @foreach($module->lessons as $index => $lesson)
                            @php
                                $progress = $lessonProgress[$lesson->id] ?? ['unlocked' => false, 'completed' => false];
                                $isUnlocked = $progress['unlocked'];
                                $isCompleted = $progress['completed'];
                            @endphp
                            <li class="lesson-accordion {{ !$isUnlocked ? 'locked' : '' }} {{ $isCompleted ? 'completed' : '' }}" data-lesson-id="{{ $lesson->id }}">
                                <div class="lesson-accordion-header" onclick="toggleAccordion(this)">
                                    <div class="lesson-status-icon {{ $isCompleted ? 'status-completed' : ($isUnlocked ? 'status-unlocked' : 'status-locked') }}">
                                        @if($isCompleted)
                                            <i class="fas fa-check"></i>
                                        @elseif($isUnlocked)
                                            <i class="fas fa-book-open"></i>
                                        @else
                                            <i class="fas fa-lock"></i>
                                        @endif
                                    </div>
                                    <div class="lesson-info">
                                        <div class="lesson-number">{{ $lesson->lesson_number }}</div>
                                        <div class="lesson-title">{{ $lesson->title }}</div>
                                    </div>
                                    @if($isUnlocked)
                                        <div class="accordion-toggle">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    @else
                                        <span class="locked-message">
                                            <i class="fas fa-info-circle"></i>
                                            Complete previous lesson to unlock
                                        </span>
                                    @endif
                                </div>

                                @if($isUnlocked)
                                    <div class="lesson-accordion-content">
                                        @if($lesson->description)
                                            <p class="lesson-description">{{ Str::limit($lesson->description, 200) }}</p>
                                        @endif

                                        <div class="content-items">
                                            @if($lesson->topics->count() > 0)
                                                @foreach($lesson->topics as $topic)
                                                    <a href="{{ route('topics.show', $topic) }}" class="content-item">
                                                        <div class="content-item-icon topic-icon">
                                                            <i class="fas fa-file-alt"></i>
                                                        </div>
                                                        <span class="content-item-text">{{ $topic->topic_number }}: {{ $topic->title }}</span>
                                                    </a>
                                                @endforeach
                                            @endif

                                            @if($lesson->quizzes->count() > 0)
                                                @foreach($lesson->quizzes as $quiz)
                                                    @php
                                                        $hasPassed = $quiz->attempts->where('passed', true)->count() > 0;
                                                    @endphp
                                                    <a href="{{ route('quizzes.show', $quiz) }}" class="content-item">
                                                        <div class="content-item-icon quiz-icon {{ !$hasPassed ? 'required' : '' }}">
                                                            <i class="fas fa-clipboard-check"></i>
                                                        </div>
                                                        <span class="content-item-text">{{ $quiz->quiz_number }}: {{ $quiz->title }}</span>
                                                        @if($hasPassed)
                                                            <span class="content-item-badge passed">Passed</span>
                                                        @else
                                                            <span class="content-item-badge">Required</span>
                                                        @endif
                                                    </a>
                                                @endforeach
                                            @endif

                                            @if($lesson->topics->count() === 0 && $lesson->quizzes->count() === 0)
                                                <div style="padding: 0.75rem; color: var(--gray-500); font-size: 0.875rem; text-align: center;">
                                                    <i class="fas fa-inbox"></i> No content yet
                                                </div>
                                            @endif
                                        </div>

                                        @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                                            <div style="display: flex; gap: 0.5rem; margin-top: 1rem; flex-wrap: wrap;">
                                                <a href="{{ route('lessons.topics.create', $lesson) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus"></i> Add Topic
                                                </a>
                                                <a href="{{ route('lessons.quizzes.create', $lesson) }}" class="btn btn-outline btn-sm">
                                                    <i class="fas fa-plus"></i> Add Quiz
                                                </a>
                                                <a href="{{ route('courses.modules.lessons.edit', [$course, $module, $lesson]) }}" class="btn btn-outline btn-sm">
                                                    <i class="fas fa-edit"></i> Edit Lesson
                                                </a>
                                                <form action="{{ route('courses.modules.lessons.destroy', [$course, $module, $lesson]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this lesson and all its content?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="empty-lessons">
                        <i class="fas fa-book-open"></i>
                        <h3>No Lessons Yet</h3>
                        <p>This module doesn't have any lessons. Add your first lesson to get started.</p>
                        @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                            <a href="{{ route('courses.modules.lessons.create', [$course, $module]) }}" class="btn btn-primary" style="margin-top: 1rem;">
                                <i class="fas fa-plus"></i> Add First Lesson
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Module Navigation -->
            <div class="module-navigation">
                @if($previousModule)
                    <a href="{{ route('courses.modules.show', [$course, $previousModule]) }}" class="nav-link nav-prev">
                        <div class="nav-direction">Previous Module</div>
                        <div class="nav-title">
                            <i class="fas fa-chevron-left"></i>
                            {{ Str::limit($previousModule->module_title, 30) }}
                        </div>
                    </a>
                @else
                    <div class="nav-placeholder"></div>
                @endif

                @if($nextModule)
                    <a href="{{ route('courses.modules.show', [$course, $nextModule]) }}" class="nav-link nav-next">
                        <div class="nav-direction">Next Module</div>
                        <div class="nav-title">
                            {{ Str::limit($nextModule->module_title, 30) }}
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                @else
                    <div class="nav-placeholder"></div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleAccordion(header) {
            const accordion = header.closest('.lesson-accordion');

            // Don't toggle if locked
            if (accordion.classList.contains('locked')) {
                return;
            }

            // Close other accordions (optional - remove if you want multiple open)
            document.querySelectorAll('.lesson-accordion.open').forEach(item => {
                if (item !== accordion) {
                    item.classList.remove('open');
                }
            });

            // Toggle current
            accordion.classList.toggle('open');
        }

        // Auto-open first unlocked lesson that isn't completed
        document.addEventListener('DOMContentLoaded', function() {
            const firstUnlocked = document.querySelector('.lesson-accordion:not(.locked):not(.completed)');
            if (firstUnlocked) {
                firstUnlocked.classList.add('open');
            } else {
                // If all completed, open the first one
                const firstLesson = document.querySelector('.lesson-accordion:not(.locked)');
                if (firstLesson) {
                    firstLesson.classList.add('open');
                }
            }
        });
    </script>
</body>
</html>
