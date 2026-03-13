<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->course_name }} - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .course-container {
            max-width: 1000px;
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
        }

        .breadcrumb a {
            color: var(--green-primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .course-header {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .course-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .course-meta-badges {
            display: flex;
            gap: 0.75rem;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-code {
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

        .course-actions {
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

        .course-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0.5rem 0;
        }

        .course-description {
            color: var(--gray-600);
            line-height: 1.7;
            margin: 1rem 0;
        }

        .course-info {
            display: flex;
            gap: 2rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .course-info span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .course-info i {
            color: var(--green-light);
        }

        .modules-section {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
        }

        .modules-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .modules-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--green-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .module-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .module-card {
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            padding: 1.25rem;
            transition: box-shadow 0.2s ease;
        }

        .module-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .module-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .module-number {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--green-primary);
            background: var(--green-pale);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .module-status {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .module-active {
            background: #d4edda;
            color: #155724;
        }

        .module-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .module-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin: 0.75rem 0 0.5rem;
        }

        .module-title a {
            color: inherit;
            text-decoration: none;
        }

        .module-title a:hover {
            color: var(--green-primary);
        }

        .module-description {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.6;
        }

        .module-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 0.75rem;
            border-top: 1px solid var(--gray-200);
        }

        .module-stats {
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        .module-stats i {
            color: var(--green-light);
            margin-right: 0.25rem;
        }

        .module-actions {
            display: flex;
            gap: 0.375rem;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        .empty-modules {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--gray-600);
        }

        .empty-modules i {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: 1rem;
        }

        .empty-modules h3 {
            font-size: 1.125rem;
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
    </style>
</head>
<body>
    <x-sidebar active="modules" />

    <div class="main-content">
        <div class="course-container">
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
                <span>{{ $course->course_code }}</span>
            </div>

            <div class="course-header">
                <div class="course-header-top">
                    <div class="course-meta-badges">
                        <span class="badge badge-code">{{ $course->course_code }}</span>
                        <span class="badge {{ $course->is_active ? 'badge-status' : 'badge-inactive' }}">
                            {{ $course->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if($course->sector)
                            <span class="badge badge-code">{{ $course->sector }}</span>
                        @endif
                    </div>

                    @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                        <div class="course-actions">
                            <a href="{{ route('courses.edit', $course) }}" class="btn btn-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @if(auth()->user()->isAdmin())
                                <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this course and all its modules?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>

                <h1 class="course-title">{{ $course->course_name }}</h1>

                @if($course->description)
                    <p class="course-description">{{ $course->description }}</p>
                @endif

                <div class="course-info">
                    @if($course->instructor)
                        <span><i class="fas fa-user"></i> {{ $course->instructor->first_name ?? $course->instructor->username }} {{ $course->instructor->last_name ?? '' }}</span>
                    @endif
                    <span><i class="fas fa-book"></i> {{ $course->modules->count() }} Modules</span>
                    <span><i class="fas fa-calendar"></i> Created {{ $course->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="modules-section">
                <div class="modules-header">
                    <h2><i class="fas fa-book-open"></i> Modules</h2>
                    @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                        <a href="{{ route('courses.modules.create', $course) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Module
                        </a>
                    @endif
                </div>

                @if($course->modules->count() > 0)
                    <div class="module-list">
                        @foreach($course->modules as $module)
                            <div class="module-card">
                                <div class="module-card-header">
                                    <span class="module-number">{{ $module->module_number }}</span>
                                    <span class="module-status {{ $module->is_active ? 'module-active' : 'module-inactive' }}">
                                        {{ $module->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>

                                <h3 class="module-title">
                                    <a href="{{ route('courses.modules.show', [$course, $module]) }}">{{ $module->module_title }}</a>
                                </h3>

                                @if($module->description)
                                    <p class="module-description">{{ Str::limit($module->description, 150) }}</p>
                                @endif

                                <div class="module-card-footer">
                                    <div class="module-stats">
                                        <i class="fas fa-file-alt"></i> {{ $module->informationSheets->count() }} Information Sheets
                                    </div>

                                    <div class="module-actions">
                                        <a href="{{ route('courses.modules.show', [$course, $module]) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                                            <a href="{{ route('courses.modules.edit', [$course, $module]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('courses.modules.destroy', [$course, $module]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this module and all its content?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-modules">
                        <i class="fas fa-book-open"></i>
                        <h3>No Modules Yet</h3>
                        <p>This course doesn't have any modules. Add your first module to get started.</p>
                        @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                            <a href="{{ route('courses.modules.create', $course) }}" class="btn btn-primary" style="margin-top: 1rem;">
                                <i class="fas fa-plus"></i> Add First Module
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
