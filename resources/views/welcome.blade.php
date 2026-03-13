<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Studyhive') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    <style>
        :root {
            --green-primary: #2d5a4a;
            --green-secondary: #4a7c6a;
            --green-accent: #6b9f8e;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-400: #95a5a6;
            --gray-600: #5a6c7d;
            --gray-800: #2c3e50;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--white);
            color: var(--gray-800);
            line-height: 1.7;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header */
        .header {
            padding: 4rem 0 3rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            margin-bottom: 1.25rem;
        }

        .header-logo {
            width: 42px;
            height: 42px;
            background: var(--green-primary);
            color: var(--white);
            font-weight: 700;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            letter-spacing: -0.5px;
        }

        .header-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--green-primary);
            letter-spacing: -0.5px;
        }

        .header-subtitle {
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--green-secondary);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 1.5rem;
        }

        .header-description {
            color: var(--gray-600);
            max-width: 620px;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .header-description p {
            margin-bottom: 1rem;
        }

        .header-description p:last-child {
            margin-bottom: 0;
        }

        .header-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 0.625rem 1.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--green-primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--green-secondary);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--green-primary);
            border: 1px solid var(--green-primary);
        }

        .btn-secondary:hover {
            background: var(--green-primary);
            color: var(--white);
        }

        /* Main Content */
        .main {
            padding: 3.5rem 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2.5rem;
        }

        .feature-item {
            padding-top: 0.5rem;
        }

        .feature-icon {
            width: 44px;
            height: 44px;
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .feature-icon svg {
            width: 22px;
            height: 22px;
            stroke: var(--green-primary);
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .feature-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--green-primary);
            margin-bottom: 0.5rem;
        }

        .feature-text {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.7;
        }

        /* Footer */
        .footer {
            padding: 2rem 0;
            border-top: 1px solid var(--gray-200);
            text-align: center;
        }

        .footer-text {
            font-size: 0.75rem;
            color: var(--gray-400);
            margin-bottom: 0.75rem;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }

        .footer-link {
            font-size: 0.75rem;
            color: var(--gray-400);
            text-decoration: none;
        }

        .footer-link:hover {
            color: var(--green-secondary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 1.25rem;
            }

            .header {
                padding: 2.5rem 0 2rem;
            }

            .header-title {
                font-size: 1.5rem;
            }

            .header-subtitle {
                font-size: 0.8125rem;
            }

            .header-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .main {
                padding: 2.5rem 0;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-brand">
                <div class="header-logo">S</div>
                <h1 class="header-title">Studyhive</h1>
            </div>
            <h2 class="header-subtitle">Computer System Servicing NC II</h2>
            <div class="header-description">
                <p>
                    The Computer System Servicing (CSS) NC II is a TESDA-recognized qualification 
                    that provides competencies in installing, configuring, maintaining, and repairing 
                    computer systems and networks.
                </p>
                <p>
                    This course prepares learners with industry-relevant skills in hardware servicing, 
                    software installation, network setup, and system troubleshooting, leading to 
                    national certification and career opportunities in the IT sector.
                </p>
            </div>
            <div class="header-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary">Enroll Now</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
            </div>
        </div>
    </header>

    <!-- Features -->
    <main class="main" id="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">Hardware Servicing</h3>
                    <p class="feature-text">
                        Assemble, disassemble, and troubleshoot computer hardware components.
                    </p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 1v6M12 17v6M1 12h6M17 12h6"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Software Installation</h3>
                    <p class="feature-text">
                        Install and configure operating systems and application software.
                    </p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Network Configuration</h3>
                    <p class="feature-text">
                        Set up and maintain local area networks and network devices.
                    </p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">System Maintenance</h3>
                    <p class="feature-text">
                        Perform preventive maintenance and diagnostic procedures.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="footer-text">&copy; {{ date('Y') }} Studyhive LMS. All rights reserved.</p>
            <div class="footer-links">
                <a href="#" class="footer-link">Privacy Policy</a>
                <a href="#" class="footer-link">Terms</a>
                <a href="#" class="footer-link">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>
