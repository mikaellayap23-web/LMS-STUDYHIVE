<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register - Studyhive</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <div class="register-header">
                <div class="register-logo">
                    <div class="logo-icon">S</div>
                    <h1 class="logo-title">Studyhive</h1>
                </div>
                <h2 class="register-subtitle">Computer System Servicing NC II</h2>
            </div>

            <form class="register-form" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-input" placeholder="First name" value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-input" placeholder="Last name" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-input" placeholder="Username" value="{{ old('username') }}" required>
                    @error('username')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-input" required>
                        <option value="student" selected>Student</option>
                    </select>
                    @error('role')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Create password" required>
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Confirm password" required>
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
            </form>

            <div class="register-footer">
                <p class="register-text">Already have an account? <a href="{{ route('login') }}" class="register-link">Login</a></p>
                <p class="register-text"><a href="{{ route('welcome') }}" class="register-link">Back to Home</a></p>
            </div>
        </div>
    </div>

    <!-- Approval Popup -->
    @if(session('success'))
    <div class="popup-overlay" id="approvalPopup">
        <div class="popup-content">
            <div class="popup-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <h3 class="popup-title">Registration Submitted</h3>
            <p class="popup-message">Your account requires admin approval. You will be notified once your account is activated.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">OK</a>
        </div>
    </div>
    @endif
</body>
</html>
