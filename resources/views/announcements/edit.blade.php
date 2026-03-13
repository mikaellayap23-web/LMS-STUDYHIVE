<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Announcement - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .form-container {
            max-width: 700px;
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

        .form-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            padding: 2rem;
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
            min-height: 200px;
            resize: vertical;
        }

        .form-group-inline {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group-inline input[type="checkbox"] {
            width: auto;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
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
    </style>
</head>
<body>
    <x-sidebar active="announcements" />

    <div class="main-content">
        <div class="form-container">
            <div class="form-header">
                <h1>Edit Announcement</h1>
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

            <form action="{{ route('announcements.update', $announcement) }}" method="POST" class="form-card">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $announcement->title) }}" required placeholder="Enter announcement title">
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" required placeholder="Enter announcement content">{{ old('content', $announcement->content) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="target_audience">Target Audience</label>
                    <select id="target_audience" name="target_audience" required>
                        <option value="all" {{ old('target_audience', $announcement->target_audience) === 'all' ? 'selected' : '' }}>All Users</option>
                        <option value="student" {{ old('target_audience', $announcement->target_audience) === 'student' ? 'selected' : '' }}>Students Only</option>
                        <option value="teacher" {{ old('target_audience', $announcement->target_audience) === 'teacher' ? 'selected' : '' }}>Teachers Only</option>
                        <option value="admin" {{ old('target_audience', $announcement->target_audience) === 'admin' ? 'selected' : '' }}>Admins Only</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="published_at">Publish Date</label>
                    <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', $announcement->published_at?->format('Y-m-d\TH:i')) }}">
                    <small style="color: var(--gray-600); font-size: 0.8125rem;">Leave empty to publish immediately</small>
                </div>

                <div class="form-group">
                    <label for="is_active">Status</label>
                    <div class="form-group-inline">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}>
                        <span>Active</span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Update Announcement
                    </button>
                    <a href="{{ route('announcements.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
