@extends('layouts.base')
@section('title', trans('messages.home'))
@section('app')


    @push('styles')
        <style>
            /* Custom Variables and Global Styles */
            :root {
                /* Dark Theme as Default */
                --background-color: #1a1a2e;
                --card-background: #1f2838;
                --text-color: #e0e0e0;
                --accent-color: #ff5722;
                /* A vibrant orange */
                --secondary-accent: #66fcf1;
                /* A bright cyan */
                --border-color: #33394a;
                --button-bg: #4c5d79;
                --button-hover: #5a7294;
            }

            [data-bs-theme="dark"] {
                --background-color: #f0f4f8;
                --card-background: #ffffff;
                --text-color: #333333;
                --accent-color: #ff8c00;
                --secondary-accent: #00bcd4;
                --border-color: #e0e0e0;
                --button-bg: #e0e4eb;
                --button-hover: #d2d6db;
            }

            .main-content {
                background-color: var(--background-color);
                color: var(--text-color);
                font-family: 'Poppins', sans-serif;
                margin: 0;
                transition: background-color 0.5s ease, color 0.5s ease;
                opacity: 0;
                animation: fadeIn 1s forwards;
            }



            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            /* .container {
                                                        max-width: 1200px;
                                                        margin: 0 auto;
                                                        padding: 2rem;
                                                    } */

            /* Header & Navbar */
            .about-header {
                text-align: center;
                padding: 4rem 2rem;
                position: relative;
                overflow: hidden;
            }

            .about-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: radial-gradient(circle, var(--accent-color) 0%, transparent 20%);
                opacity: 0.05;
                z-index: 0;
                animation: pulseBg 10s infinite;
            }

            @keyframes pulseBg {
                0% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.5);
                }

                100% {
                    transform: scale(1);
                }
            }

            .about-header-content {
                position: relative;
                z-index: 1;
            }

            .about-header h1 {
                font-size: 3.5rem;
                font-weight: 700;
                margin: 0;
                color: var(--secondary-accent);
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
                animation: slideIn 1s ease-out;
                cursor: pointer;
                transition: transform 0.3s ease;
            }

            .about-header h1:hover {
                transform: scale(1.02);
            }

            @keyframes slideIn {
                from {
                    transform: translateY(-50px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .about-header p.lead {
                font-size: 1.25rem;
                font-weight: 400;
                margin-top: 0.5rem;
            }

            .about-header .join-button {
                display: inline-block;
                background-color: var(--accent-color);
                color: #fff;
                padding: 1rem 2rem;
                border-radius: 50px;
                text-decoration: none;
                font-weight: 600;
                letter-spacing: 1px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
                transition: transform 0.3s ease, background-color 0.3s ease;
                margin-top: 1.5rem;
            }

            .about-header .join-button:hover {
                transform: translateY(-5px) scale(1.05);
                background-color: #ff6d40;
            }

            [data-bs-theme="dark"] .about-header .join-button:hover {
                background-color: #ff9933;
            }

            /* Copy button styling */
            .copy-button {
                background-color: transparent;
                border: 1px solid var(--border-color);
                color: var(--text-color);
                padding: 0.5rem 1rem;
                border-radius: 50px;
                cursor: pointer;
                transition: background-color 0.3s ease, transform 0.3s ease;
                font-size: 0.8rem;
                margin-left: 10px;
            }

            .copy-button:hover {
                background-color: var(--button-hover);
                transform: scale(1.05);
            }

            .copy-button:active {
                transform: scale(0.95);
            }

            /* Features Section */
            .features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 2rem;
                margin-top: 3rem;
            }

            .feature-block {
                background-color: var(--card-background);
                padding: 2rem;
                border-radius: 15px;
                text-align: center;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                position: relative;
                overflow: hidden;
                border: 1px solid var(--border-color);
            }

            .feature-block::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 300%;
                height: 300%;
                background: rgba(255, 255, 255, 0.05);
                border-radius: 50%;
                transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
                transform: translate(-50%, -50%) scale(0);
            }

            .feature-block:hover::before {
                transform: translate(-50%, -50%) scale(1);
            }

            .feature-block:hover {
                transform: translateY(-10px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .feature-block i {
                font-size: 3rem;
                color: var(--secondary-accent);
                margin-bottom: 1rem;
                transition: transform 0.3s ease;
            }

            .feature-block:hover i {
                transform: scale(1.1) rotate(10deg);
            }

            .feature-block h5 {
                font-weight: 600;
                color: var(--accent-color);
                margin: 0 0 0.5rem;
                position: relative;
                z-index: 1;
            }

            .feature-block p {
                font-size: 0.9rem;
                color: var(--text-color);
                opacity: 0.8;
                position: relative;
                z-index: 1;
                /* Line Clamp for 4 lines */
                display: -webkit-box;
                -webkit-line-clamp: 4;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Modal */
            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            .modal-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .modal-content {
                background-color: var(--card-background);
                color: var(--text-color);
                padding: 2.5rem;
                border-radius: 15px;
                width: 90%;
                max-width: 500px;
                text-align: center;
                position: relative;
                transform: scale(0.8);
                transition: transform 0.3s ease;
                border: 1px solid var(--border-color);
            }

            .modal-overlay.active .modal-content {
                transform: scale(1);
            }

            .modal-close {
                position: absolute;
                top: 15px;
                right: 15px;
                font-size: 1.5rem;
                color: var(--text-color);
                cursor: pointer;
                transition: color 0.3s ease;
            }

            .modal-close:hover {
                color: var(--accent-color);
            }

            /* Theme Toggle */
            .theme-toggle {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 999;
            }

            .toggle-switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
            }

            .toggle-switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
                border-radius: 34px;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
            }

            input:checked+.slider {
                background-color: var(--secondary-accent);
            }

            input:checked+.slider:before {
                transform: translateX(26px);
            }
        </style>
    @endpush

    <div class="main-content pb-5">
        <div class="about-header">
            <div class="about-header-content">
                <h1>About {{ site_name() }}</h1>
                <p class="lead">Don't break blocks alone anymore!</p>
                <a href="{{ route('login') }}" class="join-button">Join Now!</a>
            </div>
        </div>

        <div class="container">
            <div style="text-align: center; max-width: 800px; margin: 0 auto 3rem;">
                <p id="main-text">
                    <strong>{{ site_name() }}</strong> is the most popular server list and tracker for Minecraft. Its
                    goal is
                    to
                    provide an efficient way for players to find a server that suits their needs and also for server owners
                    to
                    get more players on their servers. {{ site_name() }} is part of Listforge.
                </p>
            </div>

            <div class="features">
                <div class="feature-block" data-feature="search">
                    <i class="fas fa-search"></i>
                    <h5>Search Engine</h5>
                    <p>Find the perfect server for you with our powerful, multi-criteria search engine.</p>
                </div>
                <div class="feature-block" data-feature="browse">
                    <i class="fas fa-eye"></i>
                    <h5>Browse Servers</h5>
                    <p>Explore servers by rank, country, plugins, uptime, players, and more.</p>
                </div>
                <div class="feature-block" data-feature="favorites">
                    <i class="fas fa-heart"></i>
                    <h5>Favorite System</h5>
                    <p>Create and manage your own personalized list of favorite servers for quick access.</p>
                </div>
                <div class="feature-block" data-feature="ping">
                    <i class="fas fa-globe"></i>
                    <h5>Server Ping</h5>
                    <p>Check server latency from multiple global locations to ensure the fastest connection.</p>
                </div>
                <div class="feature-block" data-feature="leaderboard">
                    <i class="fas fa-trophy"></i>
                    <h5>Achievements</h5>
                    <p>Compete with others, earn achievements, and climb our official leaderboard.</p>
                </div>
                <div class="feature-block" data-feature="vote">
                    <i class="fas fa-thumbs-up"></i>
                    <h5>Vote System</h5>
                    <p>Support your favorite servers by voting daily with our "Votifier" support.</p>
                </div>
                <div class="feature-block" data-feature="ticket">
                    <i class="fas fa-life-ring"></i>
                    <h5>Support Tickets</h5>
                    <p>Ask for help, report issues, or discuss with administrators directly.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
