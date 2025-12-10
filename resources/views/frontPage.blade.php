<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Job Portal</title>

        <!-- Animate.css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/frontpage.css') }}">
    </head>
    <body>
        <div class="page-frame">
            <!-- Header -->
            <header class="site-header">
                <div class="brand">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo">
                    <span class="brand-title">JOB PORTAL</span>
                </div>
                <nav class="nav-actions">
                    <a href="{{ route('login') }}" class="btn-signin">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-register">Register</a>
                </nav>
            </header>

            <!-- Hero Section -->
            <main class="hero">
                <div class="hero-overlay animate__animated animate__fadeIn">
                    <h1 class="hero-title">
                        Find your next Job or
                        <span class="hero-highlight">Perfect Hire</span>
                    </h1>
                    <p class="hero-subtitle">Connecting talented individuals with great opportunities</p>
                    <a href="{{ route('register') }}" class="btn-cta animate__animated animate__fadeInUp">Get Started</a>
                </div>
            </main>

            <!-- About / Vision / Mission -->
            <section class="about-section">
                <h2>About Us</h2>
                <p>
                    The DOLE Surigao del Norte Field Office, as part of the national Department of Labor and
                    Employment (DOLE), aims to promote gainful employment and worker welfare, focusing on
                    empowering people through knowledge, skills, and access to economic opportunities.
                    While specific mission, vision, and core values for the local Surigao City office
                    aren't detailed, the national DOLE's mission is to promote manpower development and
                    secure workers' rights, with core values including loyalty, simple living, political neutrality,
                    and commitment to democracy.
                </p>

                <h2>Vision</h2>
                <p>
                    With the Blessings of the Divine Providence, Surigao City 2040: A Smart City of Resilient People,
                    Enjoying a Healthy and Pleasant Environment, Driven by a Progressive, Competitive, Sustainable
                    Economy and Guided by a Transparent Accountable Governance.
                </p>

                <h2>Mission</h2>
                <p>
                    To empower workers and employers through education and support, and to facilitate employment
                    and entrepreneurship in Surigao del Norte.
                </p>
            </section>

            <!-- Footer -->
            <footer class="site-footer">
                <div class="footer-item">
                    <h3>Contact</h3>
                    <p>📞 85-359-833</p>
                </div>
                <div class="footer-item">
                    <h3>DOLE</h3>
                    <p>Photos Policy</p>
                </div>
                <div class="footer-item">
                    <h3>Follow Us</h3>
                    <p>📘 Facebook &nbsp;&nbsp; 🐦 Twitter &nbsp;&nbsp; 📸 Instagram</p>
                </div>
            </footer>
        </div>
    </body>
</html>
