@props(['active' => ''])

@php
    $user = auth()->user();
    $role = $user->role ?? 'student';
    $fullName = ($user->first_name ?? '') . ' ' . ($user->last_name ?? '');
    if (trim($fullName) === '') {
        $fullName = $user->username ?? $user->email ?? 'User';
    }
@endphp

<aside class="sidebar">
    <!-- User Profile Section -->
    <div class="sidebar-profile">
        <div class="sidebar-avatar">
            @if($user && isset($user->avatar))
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="User Avatar">
            @else
                <div class="avatar-placeholder">
                    {{ strtoupper(substr($fullName, 0, 1)) }}
                </div>
            @endif
        </div>
        <div class="sidebar-info">
            <h3 class="sidebar-name">{{ $fullName }}</h3>
            <p class="sidebar-role">{{ ucfirst($role) }}</p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav">
        @if($role === 'admin')
            <div class="nav-group">
                <a href="{{ route('profile.show') }}" class="nav-link {{ $active === 'profile' ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $active === 'dashboard' ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="nav-divider"></div>

            <div class="nav-group">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ $active === 'users' ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>User Management</span>
                </a>
                <a href="#" class="nav-link {{ $active === 'modules' ? 'active' : '' }}" onclick="return false;">
                    <i class="fas fa-book"></i>
                    <span>Modules</span>
                </a>
                <a href="#" class="nav-link {{ $active === 'assessments' ? 'active' : '' }}" onclick="return false;">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Assessments</span>
                </a>
            </div>
            
            <div class="nav-divider"></div>

            <div class="nav-group">
                <a href="{{ route('announcements.index') }}" class="nav-link {{ $active === 'announcements' ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i>
                    <span>Announcements</span>
                </a>
            </div>

        @elseif($role === 'teacher')
            <div class="nav-group">
                <a href="{{ route('profile.show') }}" class="nav-link {{ $active === 'profile' ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('teacher.dashboard') }}" class="nav-link {{ $active === 'dashboard' ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="nav-divider"></div>
            
            <div class="nav-group">
                <a href="#" class="nav-link {{ $active === 'modules' ? 'active' : '' }}" onclick="return false;">
                    <i class="fas fa-book"></i>
                    <span>Modules</span>
                </a>
                <a href="#" class="nav-link {{ $active === 'assessments' ? 'active' : '' }}" onclick="return false;">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Assessments</span>
                </a>
            </div>
            
            <div class="nav-divider"></div>

            <div class="nav-group">
                <a href="{{ route('announcements.index') }}" class="nav-link {{ $active === 'announcements' ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i>
                    <span>Announcements</span>
                </a>
            </div>

        @else
            <div class="nav-group">
                <a href="{{ route('profile.show') }}" class="nav-link {{ $active === 'profile' ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('student.dashboard') }}" class="nav-link {{ $active === 'dashboard' ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="nav-divider"></div>

            <div class="nav-group">
                <a href="#" class="nav-link {{ $active === 'my-modules' ? 'active' : '' }}" onclick="return false;">
                    <i class="fas fa-book"></i>
                    <span>My Modules</span>
                </a>
                <a href="{{ route('announcements.index') }}" class="nav-link {{ $active === 'announcements' ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i>
                    <span>Announcements</span>
                </a>
            </div>
        @endif
    </nav>

    <!-- Logout Button -->
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
