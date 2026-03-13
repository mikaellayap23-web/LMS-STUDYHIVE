<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Dashboard - Studyhive</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>
<body>
    <x-sidebar active="dashboard" />

    <div class="main-content">
        <div class="container">
            <div class="dashboard-header">
                <h1>Teacher Dashboard</h1>
                <p>Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Students</h3>
                    <p class="stat-number" id="total-students">{{ $stats['total_students'] }}</p>
                </div>
                <div class="stat-card">
                    <h3>My Modules</h3>
                    <p class="stat-number" id="my-modules">{{ $stats['my_modules'] }}</p>
                </div>
                <div class="stat-card">
                    <h3>Active Assessments</h3>
                    <p class="stat-number" id="active-assessments">{{ $stats['active_assessments'] }}</p>
                </div>
                <div class="stat-card">
                    <h3>Average Score</h3>
                    <p class="stat-number" id="average-score">{{ $stats['average_score'] }}%</p>
                </div>
            </div>

            <div class="content-section">
                <h2>Quick Actions</h2>
                <div class="actions-grid">
                    <a href="#" class="action-card">
                        <h4>Manage Modules</h4>
                        <p>Create and manage course modules</p>
                    </a>
                    <a href="#" class="action-card">
                        <h4>Assessments</h4>
                        <p>Create and grade assessments</p>
                    </a>
                    <a href="{{ route('announcements.index') }}" class="action-card">
                        <h4>Announcements</h4>
                        <p>Post announcements to students</p>
                    </a>
                    <a href="#" class="action-card">
                        <h4>Student Progress</h4>
                        <p>Track student performance</p>
                    </a>
                </div>
            </div>

            <div class="content-section">
                <h2>Latest Announcements</h2>
                @if(count($announcements) > 0)
                    <div class="announcements-list">
                        @foreach($announcements as $announcement)
                            <div class="announcement-item">
                                <div class="announcement-item-header">
                                    <h4>{{ $announcement['title'] }}</h4>
                                    <span class="announcement-date">
                                        <i class="fas fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($announcement['published_at'] ?? $announcement['created_at'])->format('M d, Y') }}
                                    </span>
                                </div>
                                <p class="announcement-item-content">{{ Str::limit($announcement['content'], 150) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div style="text-align: center; margin-top: 1.5rem;">
                        <a href="{{ route('announcements.index') }}" style="color: var(--green-primary); text-decoration: none; font-weight: 600;">
                            View All Announcements <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @else
                    <p style="color: var(--gray-600); text-align: center; padding: 1.5rem;">No announcements at the moment.</p>
                @endif
            </div>
        </div>
    </div>

    <style>
        .announcements-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .announcement-item {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            padding: 1.25rem;
            transition: border-color 0.2s ease;
        }

        .announcement-item:hover {
            border-color: var(--green-light);
        }

        .announcement-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .announcement-item-header h4 {
            color: var(--green-primary);
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
        }

        .announcement-date {
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        .announcement-item-content {
            color: var(--gray-800);
            font-size: 0.9375rem;
            line-height: 1.6;
            margin: 0;
        }
    </style>
    
    <script>
        // Auto-refresh dashboard stats every 5 seconds
        function fetchTeacherStats() {
            fetch('/api/teacher/stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-students').textContent = data.total_students;
                    document.getElementById('my-modules').textContent = data.my_modules;
                    document.getElementById('active-assessments').textContent = data.active_assessments;
                    document.getElementById('average-score').textContent = data.average_score + '%';
                })
                .catch(error => console.error('Error fetching stats:', error));
        }
        
        // Refresh stats every 5 seconds
        setInterval(fetchTeacherStats, 5000);
    </script>
</body>
</html>
