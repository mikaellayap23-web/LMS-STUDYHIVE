<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $topic->title }} - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .topic-container {
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

        .topic-header {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .topic-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .topic-meta {
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

        .topic-actions {
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

        .topic-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0.5rem 0;
        }

        .topic-info {
            display: flex;
            gap: 1.5rem;
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .topic-info span {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .topic-info i {
            color: var(--green-light);
        }

        .topic-content {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .topic-content h2 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--green-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .content-body {
            color: var(--gray-800);
            line-height: 1.8;
            white-space: pre-wrap;
        }

        .content-body p {
            margin-bottom: 1rem;
        }

        .file-attachment {
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .file-attachment h3 {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .file-attachment h3 i {
            color: var(--green-primary);
        }

        .file-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--white);
            padding: 0.75rem 1rem;
            border-radius: 6px;
            border: 1px solid var(--gray-200);
        }

        .file-details {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            background: var(--green-pale);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-icon i {
            color: var(--green-primary);
            font-size: 1.25rem;
        }

        .file-name {
            font-size: 0.9375rem;
            color: var(--gray-800);
            font-weight: 500;
        }

        .btn-download {
            background: var(--green-primary);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .btn-download:hover {
            background: var(--green-secondary);
        }

        .topic-navigation {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        .nav-link {
            flex: 1;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1rem 1.25rem;
            text-decoration: none;
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .nav-link:hover {
            border-color: var(--green-light);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
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
            margin-bottom: 0.25rem;
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

        .empty-content {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--gray-500);
        }

        .empty-content i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--gray-400);
        }
    </style>
</head>
<body>
    <x-sidebar active="modules" />

    <div class="main-content">
        <div class="topic-container">
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
                <span>{{ $topic->topic_number }}</span>
            </div>

            <div class="topic-header">
                <div class="topic-header-top">
                    <div class="topic-meta">
                        <span class="badge badge-number">{{ $topic->topic_number }}</span>
                    </div>

                    @if(auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $course->instructor_id === auth()->id()))
                        <div class="topic-actions">
                            <a href="{{ route('topics.edit', $topic) }}" class="btn btn-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('topics.destroy', $topic) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this topic?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <h1 class="topic-title">{{ $topic->title }}</h1>

                <div class="topic-info">
                    <span><i class="fas fa-file-alt"></i> {{ $informationSheet->title }}</span>
                    <span><i class="fas fa-book"></i> {{ $module->module_title }}</span>
                    <span><i class="fas fa-calendar"></i> Updated {{ $topic->updated_at->format('M d, Y') }}</span>
                </div>
            </div>

            @if($topic->content)
                <div class="topic-content">
                    <h2><i class="fas fa-align-left"></i> Content</h2>
                    <div class="content-body">
                        {!! nl2br(e($topic->content)) !!}
                    </div>
                </div>
            @else
                <div class="topic-content">
                    <div class="empty-content">
                        <i class="fas fa-file-alt"></i>
                        <p>No content has been added to this topic yet.</p>
                    </div>
                </div>
            @endif

            @if($topic->file_path)
                <div class="file-attachment">
                    <h3><i class="fas fa-paperclip"></i> Attachment</h3>
                    <div class="file-info">
                        <div class="file-details">
                            <div class="file-icon">
                                <i class="fas fa-file"></i>
                            </div>
                            <span class="file-name">{{ $topic->original_filename ?? 'Attached File' }}</span>
                        </div>
                        <a href="{{ route('topics.download', $topic) }}" class="btn-download">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            @endif

            <div class="topic-navigation">
                @if($previousTopic)
                    <a href="{{ route('topics.show', $previousTopic) }}" class="nav-link nav-prev">
                        <div class="nav-direction">Previous Topic</div>
                        <div class="nav-title">
                            <i class="fas fa-chevron-left"></i>
                            {{ Str::limit($previousTopic->title, 30) }}
                        </div>
                    </a>
                @else
                    <div class="nav-placeholder"></div>
                @endif

                @if($nextTopic)
                    <a href="{{ route('topics.show', $nextTopic) }}" class="nav-link nav-next">
                        <div class="nav-direction">Next Topic</div>
                        <div class="nav-title">
                            {{ Str::limit($nextTopic->title, 30) }}
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                @else
                    <div class="nav-placeholder"></div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
