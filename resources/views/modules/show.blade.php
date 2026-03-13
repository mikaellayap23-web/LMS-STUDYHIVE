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
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: var(--green-primary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .module-header {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .module-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .module-meta-badges {
            display: flex;
            gap: 0.75rem;
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

        .module-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0.5rem 0;
        }

        .module-description {
            color: var(--gray-600);
            line-height: 1.7;
            margin: 1rem 0;
        }

        .learning-outcomes {
            background: var(--green-pale);
            border-radius: 6px;
            padding: 1.25rem;
            margin: 1rem 0;
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

        .sheets-section {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
        }

        .sheets-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .sheets-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--green-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sheet-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .sheet-card {
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            overflow: hidden;
        }

        .sheet-card-header {
            background: linear-gradient(135deg, var(--green-pale) 0%, #e8f5e9 100%);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .sheet-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sheet-number {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--green-primary);
            background: var(--white);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .sheet-status {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .sheet-active {
            background: #d4edda;
            color: #155724;
        }

        .sheet-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .sheet-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin: 0.5rem 0 0;
        }

        .sheet-body {
            padding: 1.25rem;
        }

        .sheet-description {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .topics-list {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 4px;
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        .topics-list h5 {
            font-size: 0.8125rem;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
        }

        .topic-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0;
            font-size: 0.875rem;
            color: var(--gray-800);
        }

        .topic-item a {
            color: var(--green-primary);
            text-decoration: none;
        }

        .topic-item a:hover {
            text-decoration: underline;
        }

        .topic-item i {
            color: var(--green-light);
            font-size: 0.75rem;
        }

        .sheet-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px solid var(--gray-200);
        }

        .sheet-file {
            font-size: 0.8125rem;
            color: var(--gray-600);
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .sheet-file a {
            color: var(--green-primary);
            text-decoration: none;
        }

        .sheet-file a:hover {
            text-decoration: underline;
        }

        .sheet-actions {
            display: flex;
            gap: 0.375rem;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        .empty-sheets {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--gray-600);
        }

        .empty-sheets i {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: 1rem;
        }

        .empty-sheets h3 {
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

            <div class="breadcrumb">
                <a href="{{ route('courses.index') }}">Courses</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('courses.show', $course) }}">{{ $course->course_code }}</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $module->module_number }}</span>
            </div>

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
                            <a href="{{ route('courses.modules.edit', [$course, $module]) }}" class="btn btn-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('courses.modules.destroy', [$course, $module]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this module and all its content?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <h1 class="module-title">{{ $module->module_title }}</h1>

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

            <div class="sheets-section">
                <div class="sheets-header">
                    <h2><i class="fas fa-file-alt"></i> Information Sheets</h2>
                    @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                        <a href="{{ route('courses.modules.sheets.create', [$course, $module]) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Sheet
                        </a>
                    @endif
                </div>

                @if($module->informationSheets->count() > 0)
                    <div class="sheet-list">
                        @foreach($module->informationSheets as $sheet)
                            <div class="sheet-card">
                                <div class="sheet-card-header">
                                    <div class="sheet-meta">
                                        <span class="sheet-number">{{ $sheet->sheet_number }}</span>
                                        <span class="sheet-status {{ $sheet->is_active ? 'sheet-active' : 'sheet-inactive' }}">
                                            {{ $sheet->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <h3 class="sheet-title">{{ $sheet->title }}</h3>
                                </div>

                                <div class="sheet-body">
                                    @if($sheet->description)
                                        <p class="sheet-description">{{ Str::limit($sheet->description, 200) }}</p>
                                    @endif

                                    @if($sheet->topics->count() > 0)
                                        <div class="topics-list">
                                            <h5><i class="fas fa-list"></i> Topics ({{ $sheet->topics->count() }})</h5>
                                            @foreach($sheet->topics as $topic)
                                                <div class="topic-item">
                                                    <i class="fas fa-chevron-right"></i>
                                                    <a href="{{ route('topics.show', $topic) }}">{{ $topic->topic_number }}: {{ $topic->title }}</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="sheet-footer">
                                        <div class="sheet-file">
                                            @if($sheet->file_path)
                                                <i class="fas fa-paperclip"></i>
                                                <a href="{{ route('courses.modules.sheets.download', [$course, $module, $sheet]) }}">
                                                    {{ $sheet->original_filename ?? 'Download File' }}
                                                </a>
                                            @else
                                                <span style="color: var(--gray-400);">No file attached</span>
                                            @endif
                                        </div>

                                        <div class="sheet-actions">
                                            @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                                                <a href="{{ route('sheets.topics.create', $sheet) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus"></i> Topic
                                                </a>
                                                <a href="{{ route('courses.modules.sheets.edit', [$course, $module, $sheet]) }}" class="btn btn-secondary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('courses.modules.sheets.destroy', [$course, $module, $sheet]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this information sheet and all its topics?');">
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
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-sheets">
                        <i class="fas fa-file-alt"></i>
                        <h3>No Information Sheets Yet</h3>
                        <p>This module doesn't have any information sheets. Add your first sheet to get started.</p>
                        @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                            <a href="{{ route('courses.modules.sheets.create', [$course, $module]) }}" class="btn btn-primary" style="margin-top: 1rem;">
                                <i class="fas fa-plus"></i> Add First Information Sheet
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
