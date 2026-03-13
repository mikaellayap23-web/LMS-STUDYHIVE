<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .courses-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .courses-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-200);
        }

        .courses-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--green-primary);
        }

        .btn-create {
            background: var(--green-primary);
            color: var(--white);
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: background 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-create:hover {
            background: var(--green-secondary);
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .course-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .course-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .course-code {
            background: var(--green-pale);
            color: var(--green-primary);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .course-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .course-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0.75rem 0;
            line-height: 1.4;
        }

        .course-title a {
            color: inherit;
            text-decoration: none;
        }

        .course-title a:hover {
            color: var(--green-primary);
        }

        .course-description {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .course-meta {
            display: flex;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        .course-meta span {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .course-meta i {
            color: var(--green-light);
        }

        .course-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.8125rem;
            font-weight: 500;
            text-decoration: none;
            transition: opacity 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-view {
            background: var(--green-primary);
            color: var(--white);
        }

        .btn-edit {
            background: var(--green-light);
            color: var(--white);
        }

        .btn-delete {
            background: #e74c3c;
            color: var(--white);
        }

        .btn-action:hover {
            opacity: 0.85;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1.5rem;
            color: var(--gray-600);
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--gray-400);
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
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

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <x-sidebar active="modules" />

    <div class="main-content">
        <div class="courses-container">
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

            <div class="courses-header">
                <h1><i class="fas fa-graduation-cap"></i> Courses</h1>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('courses.create') }}" class="btn-create">
                        <i class="fas fa-plus"></i> New Course
                    </a>
                @endif
            </div>

            <div class="courses-grid">
                @forelse($courses as $course)
                    <div class="course-card">
                        <div class="course-header">
                            <span class="course-code">{{ $course->course_code }}</span>
                            <span class="course-status {{ $course->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $course->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <h3 class="course-title">
                            <a href="{{ route('courses.show', $course) }}">{{ $course->course_name }}</a>
                        </h3>

                        @if($course->description)
                            <p class="course-description">{{ Str::limit($course->description, 120) }}</p>
                        @endif

                        <div class="course-meta">
                            <span><i class="fas fa-book"></i> {{ $course->modules_count }} Modules</span>
                            @if($course->instructor)
                                <span><i class="fas fa-user"></i> {{ $course->instructor->first_name ?? $course->instructor->username }}</span>
                            @endif
                            @if($course->sector)
                                <span><i class="fas fa-tag"></i> {{ $course->sector }}</span>
                            @endif
                        </div>

                        @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                            <div class="course-actions">
                                <a href="{{ route('courses.show', $course) }}" class="btn-action btn-view">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('courses.edit', $course) }}" class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this course? All modules and content will be deleted.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <div class="course-actions">
                                <a href="{{ route('courses.show', $course) }}" class="btn-action btn-view">
                                    <i class="fas fa-eye"></i> View Course
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>No Courses Available</h3>
                        <p>There are no courses to display at the moment.</p>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('courses.create') }}" class="btn-create" style="margin-top: 1rem;">
                                <i class="fas fa-plus"></i> Create Your First Course
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            @if($courses->hasPages())
                <div class="pagination-wrapper">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
