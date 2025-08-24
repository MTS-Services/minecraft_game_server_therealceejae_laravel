@extends('layouts.base')
@section('title', trans('messages.home'))
@section('app')


    @push('styles')
        <style>
            /* Custom CSS Variables for Theming */
            :root {
                --minecraft-green: #4CAF50;
                --minecraft-brown: #8B4513;
                --minecraft-orange: #FF8C00;
                --minecraft-dark: #2C3E50;
                --minecraft-light: #ECF0F1;
            }

            body {
                min-height: 100vh;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                transition: background 0.3s, color 0.3s;
                background-color: #f0f0f0;
            }

            .main-container {
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                margin: 2rem auto;
                max-width: 950px;
                transition: background 0.3s, color 0.3s;
            }

            .header-section {
                background: linear-gradient(135deg, var(--minecraft-orange), #FF6B35);
                color: white;
                padding: 2rem;
                border-radius: 20px 20px 0 0;
                text-align: center;
                position: relative;
                /* Needed for positioning the toggle button */
            }

            .theme-toggle-btn {
                position: absolute;
                top: 1rem;
                right: 1rem;
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: white;
                padding: 0.5rem 0.75rem;
                border-radius: 10px;
                cursor: pointer;
                transition: background 0.3s ease;
            }

            .theme-toggle-btn:hover {
                background: rgba(255, 255, 255, 0.3);
            }

            .section-card {
                border-radius: 15px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
                margin-bottom: 1.5rem;
                padding: 2rem;
                transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s, color 0.3s;
            }

            .section-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            }

            .section-card-header {
                background: linear-gradient(135deg, var(--minecraft-green), #45a049);
                color: white;
                padding: 1.2rem;
                border-radius: 15px 15px 0 0;
                border: none;
                margin: -2rem -2rem 1.5rem -2rem;
                font-size: 1.4rem;
                font-weight: 600;
            }

            .content-list {
                list-style: none;
                padding: 0;
            }

            .content-list li {
                border: none;
                background: rgba(76, 175, 80, 0.1);
                margin-bottom: 0.5rem;
                border-radius: 10px;
                padding: 0.8rem 1rem;
                border-left: 4px solid var(--minecraft-green);
            }

            .warning-box {
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 10px;
                padding: 1rem 1.25rem;
                margin: 1.5rem 0;
            }

            /* DARK MODE STYLES */
            [data-bs-theme="dark"] {
                background-color: #1e1e2f;
                color: #e5e5e5;
            }

            [data-bs-theme="dark"] .main-container {
                background: #2a2a3a;
            }

            [data-bs-theme="dark"] .section-card {
                background: #333344;
                color: #f1f1f1;
            }

            [data-bs-theme="dark"] .content-list li {
                background: rgba(76, 175, 80, 0.2);
                color: #e5e5e5;
            }

            [data-bs-theme="dark"] .warning-box {
                background: #2c1b1b;
                border: 1px solid #7f1d1d;
            }
        </style>
    @endpush


    <div class="container my-5">
        <div class="main-container">
            <div class="header-section">
                <h1><i class="fas fa-file-contract me-3"></i>Terms of Service</h1>
                <p class="lead mb-0">The rules and conditions for using {{ config('app.name') }}</p>
            </div>

            <div class="p-4 border-top border-2">
                <p>Welcome to our website. If you continue to browse and use this website, you are
                    agreeing to comply with
                    and be bound by the following terms and conditions of use, which together with our privacy policy govern
                    {{ config('app.name') }}'s relationship with you in relation to this website.</p>
                <div class="intro-text alert alert-warning">
                    <p class="mb-0">The term '{{ config('app.name') }}' or 'us' or 'we' refers to the owner of the
                        website. The
                        term 'you' refers to the user or viewer of our website.</p>
                </div>
            </div>

            <div class="p-4">
                <!-- User Content Section -->
                <div class="section-card">
                    <h3 class="section-card-header">
                        User Content
                    </h3>
                    <p>By submitting any kind of content (text, image, URL) on {{ config('app.name') }}, you agree to take
                        full
                        responsability for the content you submit. You also accept that we are not responsible for what you
                        publish on our website. You agree that the content you publish is in compliance with all applicable
                        laws and regulations.</p>
                    <p>You may not publish any of the following content on our website:</p>
                    <ul class="content-list">
                        <li>Content that is obscene, vulgar, sexually explicit, pornographic, or otherwise offensive.</li>
                        <li>Content that is unlawful, harmful, threatening, abusive, harassing, defamatory, or hateful.</li>
                        <li>Content that infringes upon any patent, trademark, trade secret, copyright, or other proprietary
                            rights.</li>
                        <li>Content that contains software viruses or any other computer code, files, or programs.</li>
                        <li>Spam, mass advertisement, or any kind of unwanted commercial messages.</li>
                    </ul>
                </div>

                <!-- Votes -->
                <div class="section-card">
                    <h3 class="section-card-header">
                        Votes
                    </h3>
                    <p>You can vote for your favorite server once every 24 hours per IP address. Cheating the voting system
                        is strictly forbidden and may lead to a permanent ban of your account and server from our website.
                        Cheating includes, but is not limited to:</p>
                    <ul class="content-list">
                        <li>Using proxies or VPN to vote multiple times.</li>
                        <li>Using bots, scripts, or automation for multiple votes.</li>
                    </ul>
                </div>

                <!-- Termination -->
                <div class="section-card">
                    <h3 class="section-card-header">
                        Termination
                    </h3>
                    <p>We reserve the right to terminate any account at any time with or without reason.</p>
                </div>

                <!-- Warranty Disclaimer -->
                <div class="section-card">
                    <h3 class="section-card-header">
                        Warranty Disclaimer
                    </h3>
                    <div class="warning-box">
                        <p class="mb-0">There are no warranties of any kind, express or implied, regarding the service.
                        </p>
                    </div>
                </div>

                <!-- Change of Terms -->
                <div class="section-card">
                    <h3 class="section-card-header">
                        Change of Terms
                    </h3>
                    <p>We reserve the right to modify these Terms of Service at any time with or without notice.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
