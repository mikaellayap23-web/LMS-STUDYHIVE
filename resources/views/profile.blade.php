<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Profile - {{ config('app.name', 'Studyhive') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>

    <!-- Profile Header -->
    <header class="profile-header">
        <div class="container">
            <h1>My Profile</h1>
            <p>Manage your account information and settings</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-card-header">
                    <h2>Profile Information</h2>
                </div>
                <div class="profile-card-body">
                    <div class="profile-info">
                        <!-- Avatar Section -->
                        <div class="profile-avatar-section">
                            <div class="profile-avatar">
                                @if(auth()->user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo">
                                @else
                                    {{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->username ?? auth()->user()->email, 0, 1)) }}
                                @endif
                            </div>
                            <button type="button" class="avatar-upload-btn" onclick="alert('Avatar upload functionality coming soon!')">
                                Change Avatar
                            </button>
                        </div>

                        <!-- Profile Details Section -->
                        <div class="profile-details-section">
                            <!-- Status and Role Badges -->
                            <div>
                                <span class="status-badge status-{{ auth()->user()->status }}">
                                    {{ auth()->user()->status }}
                                </span>
                                <span class="role-badge">
                                    {{ auth()->user()->role }}
                                </span>
                            </div>

                            <!-- Profile Form -->
                            <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                                @csrf
                                @method('PUT')

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input 
                                            type="text" 
                                            id="first_name" 
                                            name="first_name" 
                                            class="form-input" 
                                            value="{{ old('first_name', auth()->user()->first_name) }}"
                                            placeholder="Enter first name"
                                        >
                                        @error('first_name')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input 
                                            type="text" 
                                            id="last_name" 
                                            name="last_name" 
                                            class="form-input" 
                                            value="{{ old('last_name', auth()->user()->last_name) }}"
                                            placeholder="Enter last name"
                                        >
                                        @error('last_name')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="username" class="form-label">Username</label>
                                        <input 
                                            type="text" 
                                            id="username" 
                                            name="username" 
                                            class="form-input" 
                                            value="{{ old('username', auth()->user()->username) }}"
                                            placeholder="Enter username"
                                        >
                                        @error('username')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input 
                                            type="email" 
                                            id="email" 
                                            name="email" 
                                            class="form-input" 
                                            value="{{ old('email', auth()->user()->email) }}"
                                            placeholder="Enter email address"
                                        >
                                        @error('email')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information Card -->
            <div class="profile-card">
                <div class="profile-card-header">
                    <h2>Account Information</h2>
                </div>
                <div class="profile-card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Account Created</div>
                            <div class="info-value">{{ auth()->user()->created_at->format('M d, Y') }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Last Updated</div>
                            <div class="info-value">{{ auth()->user()->updated_at->format('M d, Y') }}</div>
                        </div>

                        <div class="info-item full-width">
                            <div class="info-label">Email Verification Status</div>
                            <div class="info-value">
                                @if(auth()->user()->email_verified_at)
                                    <span style="color: var(--success);">✓ Verified</span>
                                @else
                                    <span style="color: var(--gray-600);">Not verified</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Auto-hide success messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-success');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.3s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
