<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Announcements - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .announcements-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .announcements-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-200);
        }

        .announcements-header h1 {
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
        }

        .btn-create:hover {
            background: var(--green-secondary);
        }

        .announcement-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.25rem;
            transition: box-shadow 0.2s ease;
        }

        .announcement-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .announcement-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .announcement-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--green-primary);
            margin: 0;
        }

        .announcement-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        .announcement-meta i {
            margin-right: 0.375rem;
        }

        .announcement-content {
            color: var(--gray-800);
            line-height: 1.7;
            margin-bottom: 1rem;
        }

        .announcement-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .announcement-author {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .announcement-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.8125rem;
            font-weight: 500;
            text-decoration: none;
            transition: opacity 0.2s ease;
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

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-all { background: var(--green-pale); color: var(--green-primary); }
        .badge-student { background: #e3f2fd; color: #1976d2; }
        .badge-teacher { background: #fff3e0; color: #f57c00; }
        .badge-admin { background: #fce4ec; color: #c2185b; }

        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--gray-600);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: 1rem;
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

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 4px;
            text-decoration: none;
            color: var(--gray-800);
            font-size: 0.875rem;
        }

        .pagination a:hover {
            background: var(--gray-200);
        }

        .pagination .active {
            background: var(--green-primary);
            color: var(--white);
            border-color: var(--green-primary);
        }

        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <x-sidebar active="announcements" />

    <div class="main-content">
        <div class="announcements-container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="announcements-header">
                <h1>Announcements</h1>
                @if(auth()->user()->role !== 'student')
                    <a href="{{ route('announcements.create') }}" class="btn-create">
                        <i class="fas fa-plus"></i> New Announcement
                    </a>
                @endif
            </div>

            @if($announcements->count() > 0)
                @foreach($announcements as $announcement)
                    <div class="announcement-card">
                        <div class="announcement-header">
                            <h3 class="announcement-title">{{ $announcement->title }}</h3>
                            <span class="badge badge-{{ $announcement->target_audience }}">
                                {{ $announcement->target_audience }}
                            </span>
                        </div>

                        <div class="announcement-meta">
                            <span><i class="fas fa-calendar"></i> {{ $announcement->published_at?->format('M d, Y') ?? 'Draft' }}</span>
                        </div>

                        <div class="announcement-content">
                            {{ Str::limit($announcement->content, 300) }}
                        </div>

                        <div class="announcement-footer">
                            <span class="announcement-author">
                                <i class="fas fa-user"></i> {{ $announcement->creator->first_name ?? $announcement->creator->username ?? 'Admin' }}
                            </span>

                            @if(auth()->user()->role !== 'student')
                                <div class="announcement-actions">
                                    <a href="{{ route('announcements.edit', $announcement) }}" class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="pagination">
                    {{ $announcements->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-bullhorn"></i>
                    <h3>No Announcements</h3>
                    <p>There are no announcements at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
