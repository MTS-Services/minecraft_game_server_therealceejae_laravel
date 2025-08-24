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
                /* Negative margin to pull it into the card */
                font-size: 1.4rem;
                font-weight: 600;
            }

            .content-text {
                line-height: 1.7;
            }

            .highlight {
                font-weight: 600;
                color: var(--minecraft-orange);
            }

            .contact-link {
                color: #ff6b35;
                font-weight: 500;
                text-decoration: none;
            }

            .contact-link:hover {
                text-decoration: underline;
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

            [data-bs-theme="dark"] .highlight {
                color: #f59e0b;
            }

            [data-bs-theme="dark"] .contact-link {
                color: #ff6b35;
            }

            [data-bs-theme="dark"] .contact-link:hover {
                color: #ff8c00;
            }
        </style>
    @endpush


    <div class="container my-5">
        <div class="main-container">
            <div class="header-section">
                <h1><i class="fas fa-user-shield me-3"></i>Privacy Policy</h1>
                <p class="lead mb-0">How we protect your data at {{ config('app.name') }}</p>
            </div>

            <div class="p-4 border-top border-2">
                <p>We collect only the following data for the use of <span
                        class="highlight">"{{ config('app.name') }}"</span>. We
                    never sell your personal information to third parties. If you have any questions or concerns regarding
                    our privacy policy, please contact us at: <a href=""
                        class="contact-link">contact@{{ config('app.name') }}</a></p>
                <div class="last-revision text-muted">
                    <strong>Last Revision:</strong> March 17th, 2024
                </div>
            </div>

            <div class="p-4">
                <!-- What Data Do We collect? -->
                <div class="section-card">
                    <h3 class="section-card-header">
                        What Data Do We collect?
                    </h3>
                    <div class="content-text">
                        Like many other websites, we make use of log files. The information inside the log files includes
                        internet protocol (IP) addresses, type of browser, type of operating system, Internet Service
                        Provider (ISP), date/time, referring/exit pages.
                    </div>
                    <div class="content-text">
                        IP addresses and other such information are not linked to any other information that are personally
                        identifiable.
                    </div>
                </div>

                <!-- Data Retention Time -->
                <div class="section-card">
                    <h3 class="section-card-header">
                        Data Retention Time
                    </h3>
                    <div class="content-text">
                        All data is kept for as long as needed for the purpose of which it was collected.
                    </div>
                </div>

                <!-- Third Parties -->
                <div class="section-card">
                    <h3 class="section-card-header">
                        Third Parties
                    </h3>
                    <div class="content-text">
                        We may share some information (IP address, user agent) with third parties to monitor and fight
                        against fraudulent votes. We currently share this information with ProxyCheck.io.
                    </div>
                    <div class="content-text">
                        By using the website you agree that we may use your IP address to check if it's a proxy or VPN. This
                        information is shared with ProxyCheck.io.
                    </div>
                </div>

                <!-- Cookies -->
                <div class="section-card">
                    <h3 class="section-card-header">
                        Cookies
                    </h3>
                    <div class="content-text">
                        We use cookies to store information about visitors' preferences, to record user-specific information
                        on which pages the user access or visit, customize webpage content based on visitors' browser type
                        or other information that the visitor sends via their browser.
                    </div>
                </div>

                <!-- External Links -->
                <div class="section-card">
                    <h3 class="section-card-header">
                        External Links
                    </h3>
                    <div class="content-text">
                        <p>Our website may contain links to other websites of interest. However, once you have used these
                            links to leave our site, you should note that we do not have any control over that other
                            website. Therefore, we cannot be responsible for the protection and privacy of any information
                            which you provide whilst visiting such sites and such sites are not governed by this privacy
                            statement. You should exercise caution and look at the privacy statement applicable to the
                            website in question.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
