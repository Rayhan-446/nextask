<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nextask - Smart Task Management Platform</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --accent: #ec4899;
            --light-bg: #f8fafc;
            --dark-text: #1e293b;
            --gray-text: #64748b;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-text);
            background: var(--light-bg);
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 1rem 2rem !important;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .navbar-brand:hover {
            opacity: 0.8;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%);
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: 5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(30px);
            }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 900px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--dark-text);
            letter-spacing: -1px;
        }

        .hero h1 .gradient-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 1.3rem;
            color: var(--gray-text);
            margin-bottom: 2.5rem;
            line-height: 1.6;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* CTA Buttons */
        .btn-primary-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.875rem 2.5rem;
            border-radius: 50px;
            font-size: 1.05rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .btn-primary-gradient:active {
            transform: translateY(0);
        }

        .btn-outline-custom {
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .cta-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        /* Features Section */
        .features {
            padding: 5rem 2rem;
            background: white;
            margin-top: 4rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 3rem;
        }

        .feature-card {
            padding: 2rem;
            border-radius: 12px;
            background: linear-gradient(135deg, #f8fafc 0%, #f0f4ff 100%);
            border: 1px solid rgba(99, 102, 241, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary);
            box-shadow: 0 12px 30px rgba(99, 102, 241, 0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 1.8rem;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--dark-text);
        }

        .feature-card p {
            color: var(--gray-text);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Section Title */
        .section-title {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--dark-text);
        }

        .section-subtitle {
            text-align: center;
            color: var(--gray-text);
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto 2rem;
        }

        /* Footer */
        footer {
            background: var(--dark-text);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            margin-top: 4rem;
        }

        footer p {
            margin: 0.5rem 0;
            opacity: 0.8;
        }

        footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }

            .hero-description {
                font-size: 1.1rem;
            }

            .cta-group {
                flex-direction: column;
                align-items: center;
            }

            .btn-primary-gradient,
            .btn-outline-custom {
                width: 100%;
                max-width: 300px;
            }

            .section-title {
                font-size: 2rem;
            }
        }

        /* Navbar buttons */
        .nav-buttons {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .nav-btn {
            text-decoration: none;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .nav-btn-login {
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .nav-btn-login:hover {
            background: var(--primary);
            color: white;
        }

        .nav-btn-register {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
        }

        .nav-btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="#">
                <i class="fas fa-rocket"></i> Nextask
            </a>
            <div class="nav-buttons">
                <a href="login.php" class="nav-btn nav-btn-login">Login</a>
                <a href="register.php" class="nav-btn nav-btn-register">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>
                Manage Tasks with
                <span class="gradient-text">Intelligence</span>
            </h1>
            <p class="hero-description">
                Streamline your workflow, collaborate seamlessly with your team, and achieve more. Nextask brings simplicity and power to task management.
            </p>
            <div class="cta-group">
                <a href="register.php" class="btn-primary-gradient">
                    <i class="fas fa-arrow-right me-2"></i>Get Started Free
                </a>
                <a href="#features" class="btn-outline-custom">
                    <i class="fas fa-play-circle me-2"></i>Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">Why Choose Nextask?</h2>
            <p class="section-subtitle">Everything you need to stay organized and productive</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3>Smart Organization</h3>
                    <p>Organize your tasks with categories, priorities, and due dates. Keep everything structured and easy to find.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Team Collaboration</h3>
                    <p>Work together in real-time, assign tasks, and share progress with your team members instantly.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Track Progress</h3>
                    <p>Monitor project progress with intuitive dashboards and detailed analytics to keep projects on track.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile Friendly</h3>
                    <p>Access your tasks anywhere, anytime. Manage your workflow on the go with our responsive design.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Smart Notifications</h3>
                    <p>Never miss deadlines with intelligent reminders and real-time notifications for task updates.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Secure & Private</h3>
                    <p>Your data is protected with enterprise-grade security and encryption for peace of mind.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p><strong>Nextask</strong> - Smart Task Management Platform</p>
            <p>© 2026 Nextask. All rights reserved.</p>
            <p>
                <a href="#privacy">Privacy Policy</a> • 
                <a href="#terms">Terms of Service</a> • 
                <a href="#contact">Contact Us</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
