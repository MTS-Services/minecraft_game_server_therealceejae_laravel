@extends('layouts.base')
@section('title', trans('server-listing::messages.server_submission.title'))
@include('admin.elements.editor')
@section('app')
    @push('styles')
        <style>
            :root {
                /* Primary Colors */
                --primary-green: #4CAF50;
                --primary-blue: #2196F3;
                --primary-purple: #9C27B0;
                --primary-gold: #FFD700;
                --primary-orange: #FF9800;

                /* Status Colors */
                --status-online: #28A745;
                --status-offline: #DC3545;
                --status-warning: #FFC107;

                /* Background Colors */
                --bg-primary: #ffffff;
                --bg-secondary: #f8f9fa;
                --bg-dark: #343a40;
                --bg-darker: #212529;

                /* Border Colors */
                --border-light: #dee2e6;
                --border-primary: #e1bee7;
                --border-dark: #495057;

                /* Text Colors */
                --text-primary: #212529;
                --text-secondary: #6c757d;
                --text-muted: #999;
                --text-white: #ffffff;

                /* Spacing */
                --spacing-xs: 0.25rem;
                --spacing-sm: 0.5rem;
                --spacing-md: .5rem;
                --spacing-lg: .5rem;
                --spacing-xl: 2rem;

                /* Border Radius */
                --border-radius-sm: 0.375rem;
                --border-radius-md: 0.5rem;
                --border-radius-lg: 0.75rem;
                --border-radius-xl: 1rem;

                /* Shadows */
                --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                --shadow-lg: 1rem 3rem rgba(0, 0, 0, 0.175);

                /* Logo/Image Sizes */
                --logo-size-sm: 40px;
                --logo-size-md: 50px;
                --logo-size-lg: 60px;
                --banner-height: 60px;
                --banner-width: 468px;
            }
            .page-title {
                font-size: 2rem;
                font-weight: 600;
                color: #fd7e14;
            }

            .action-buttons .btn {
                border-radius: 50px;
                margin-right: .5rem;
            }

            .table thead {
                background-color: #f1f3f5;
            }

            .badge {
                display: inline-block;
                min-width: 10px;
                padding: 3px 7px;
                font-size: 12px;
                font-weight: bold;
                line-height: 1;
                color: #fff;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                background-color: #777;
                border-radius: 10px;
            }

            .btn-info {
                color: #fff;
                background-color: #5bc0de;
                border-color: #46b8da;
            }

            .btn-default {
                color: #333;
                background-color: #fff;
                border-color: #ccc;
            }

            /* Regular Server Cards */
            .server-card {
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
                border: 2px solid var(--border-primary);
                margin-bottom: var(--spacing-lg);
            }

            .server-card-header {
                background: linear-gradient(135deg, var(--bg-dark), var(--bg-darker));
                padding: 1.2rem;
                color: var(--text-white);
            }

            .server-row {
                transition: all 0.3s ease;
                padding: var(--spacing-md);
                border-bottom: 1px solid var(--border-light);
                position: relative;
            }

            .server-row:hover {
                background-color: var(--bg-secondary);
                transform: translateX(5px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            /* The Missing CSS from your original style tag has been added below */



            /* Dark mode variables */
            [data-bs-theme="dark"] {
                --bg-primary: #212529;
                --bg-secondary: #343a40;
                --text-primary: #ffffff;
                --text-secondary: #adb5bd;
                --border-light: #495057;
            }

            .h5,
            h5 {
                font-size: .8rem;
            }

            /* Base Styles */
            .minecraft-header {
                position: relative;
                overflow: hidden;
                border-bottom: 3px solid var(--primary-green);
            }

            .minecraft-header img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                object-position: center;
            }

            .minecraft-header .position-absolute {
                background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.3) 100%);
            }

            /* Welcome Section */
            .welcome-section h1 {
                color: var(--primary-blue);
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: var(--spacing-md);
            }

            .welcome-section .lead {
                color: var(--text-secondary);
                font-size: 1.1rem;
            }

            /* Filter Card */
            .filter_card {
                background: linear-gradient(135deg, #f3e5f5, #e3f2fd);
                border: 2px solid var(--border-primary) !important;
                border-radius: var(--border-radius-lg);
                box-shadow: var(--shadow-sm);
            }

            .filter_button {
                background: linear-gradient(135deg, var(--primary-purple), #673ab7);
                color: var(--text-white);
                border: none;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .filter_button:hover {
                background: linear-gradient(135deg, #673ab7, var(--primary-purple));
                color: var(--text-white);
                transform: translateY(-2px);
            }

            .reset_button {
                background: linear-gradient(135deg, #a0b73a, #7bb027);
                color: var(--text-white);
                border: none;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .reset_button:hover {
                background: linear-gradient(135deg, #7bb027, #a0b73a);
                color: var(--text-white);
                transform: translateY(-2px);
            }

            /* Top 10 Premium Servers - Ultra Premium Styling */
            .premium-top10-container {
                position: relative;
                margin-bottom: var(--spacing-xl);
            }

            .premium-top10-header {
                background: linear-gradient(135deg, var(--primary-gold), #ffed4e, var(--primary-gold));
                background-size: 200% 200%;
                animation: premiumGradient 3s ease infinite;
                padding: 2rem;
                border-radius: 20px;
                margin-bottom: 2rem;
                box-shadow: 0 10px 30px rgba(255, 215, 0, 0.3);
                text-align: center;
            }

            .premium-title {
                font-size: 1.5rem;
                font-weight: 900;
                margin-bottom: 0.5rem;
            }

            .premium-text-gradient {
                background: linear-gradient(45deg, var(--primary-gold), var(--primary-orange), var(--primary-gold));
                background-size: 200% 200%;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                animation: textShine 3s ease-in-out infinite;
            }

            .premium-subtitle {
                color: #333;
                font-size: .8rem;
                font-weight: 500;
            }

            .premium-top10-card {
                border-radius: 25px;
                overflow: hidden;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
                border: 3px solid transparent;
                background: linear-gradient(white, white) padding-box,
                    linear-gradient(45deg, var(--primary-gold), var(--primary-orange)) border-box;
            }

            .premium-top10-card-header {
                background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
                padding: 1.5rem;
                border-bottom: 3px solid var(--primary-gold);
            }

            .premium-top10-body {
                background: linear-gradient(135deg, #f8f9fa, #ffffff);
            }

            .premium-top10-row {
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
                padding: var(--spacing-lg);
                border-bottom: 1px solid var(--border-light);
            }

            .premium-top10-row::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.1), transparent);
                transition: left 0.5s;
            }

            .premium-top10-row:hover::before {
                left: 100%;
            }

            .premium-top10-row:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 40px rgba(255, 215, 0, 0.2);
            }

            .premium-top10-row:last-child {
                border-bottom: none;
            }

            /* Premium Servers Styling */
            .premium-header {
                background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
                padding: 1.5rem;
                border-radius: 15px;
                border: 2px solid var(--border-primary);
                text-align: center;
                margin: var(--spacing-lg) 0;
                margin-bottom: 2rem;
            }

            .premium-section-title {
                font-size: 1.5rem;
                font-weight: 800;
                margin-bottom: 0.5rem;
            }

            .premium-gradient-text {
                background: linear-gradient(45deg, var(--primary-purple), #673ab7, #3f51b5);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .premium-section-subtitle {
                color: #666;
                font-size: .8rem;
                font-weight: 500;
                margin: 0;
            }

            .premium-card {
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
                border: 2px solid var(--border-primary);
            }

            .premium-card-header {
                background: linear-gradient(135deg, var(--primary-purple), #673ab7);
                padding: 1.2rem;
                color: white;
            }

            .premium-body {
                background: linear-gradient(135deg, #fafafa, #f5f5f5);
            }

            .premium-server-row {
                transition: all 0.3s ease;
                position: relative;
                padding: var(--spacing-md);
                border-bottom: 1px solid var(--border-light);
            }

            .premium-server-row:hover {
                transform: translateX(10px);
                background: linear-gradient(135deg, #f8f9fa, #e9ecef);
                box-shadow: 0 10px 25px rgba(156, 39, 176, 0.15);
            }

            .premium-server-row:last-child {
                border-bottom: none;
            }

            /* Server Logos */
            .server-logo,
            .premium-logo-container,
            .elit-server-logo {
                width: var(--logo-size-lg);
                height: var(--logo-size-lg);
                border-radius: var(--border-radius-sm);
                overflow: hidden;
                border: 2px solid var(--border-light);
                transition: border-color 0.2s ease;
                position: relative;
            }

            .server-logo img,
            .premium-logo-container img,
            .elit-server-logo img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .server-row:hover .server-logo,
            .premium-server-row:hover .premium-logo-container,
            .premium-top10-row:hover .elit-server-logo {
                border-color: var(--primary-blue);
            }

            /* Server Banners */
            .server-banner,
            .premium-banner-container,
            .premium-server-banner {
                width: var(--banner-width);
                height: var(--banner-height);
                border-radius: var(--border-radius-sm);
                overflow: hidden;
                position: relative;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            }

            .server-banner img,
            .premium-banner,
            .premium-server-banner img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.2s ease;
            }

            .server-banner:hover img,
            .premium-banner-container:hover .premium-banner,
            .premium-server-banner:hover img {
                transform: scale(1.02);
            }

            .banner-overlay,
            .premium-server-overlay,
            .premium-banner-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
                padding: var(--spacing-sm) var(--spacing-md);
                z-index: 2;
            }

            /* Badges */
            .version-badge,
            .premium-version,
            .premium-version-badge {
                background: linear-gradient(135deg, var(--primary-blue), var(--primary-green));
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
                border-radius: var(--border-radius-sm);
                border: none;
                font-weight: 600;
            }

            .status-badge,
            .premium-online-badge,
            .premium-status-badge {
                background: var(--status-online);
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
                border-radius: 15px;
                font-weight: 600;
            }

            .premium-online-badge.offline,
            .premium-status-badge.offline {
                background: var(--status-offline);
            }

            .status-badge.offline {
                background: var(--status-offline);
            }

            .rank-badge,
            .premium-rank-badge {
                background: linear-gradient(135deg, var(--primary-gold), var(--primary-orange));
                color: var(--text-primary);
                font-size: 0.75rem;
                padding: 0.3rem 0.5rem;
                border-radius: var(--border-radius-sm);
                font-weight: 700;
            }

            .premium-rank-container {
                background: linear-gradient(135deg, var(--primary-purple), #673ab7);
                color: var(--text-white);
                font-size: 0.75rem;
                padding: 0.3rem 0.5rem;
                border-radius: var(--border-radius-sm);
                font-weight: 700;
            }

            .simple-server-badge {
                background: linear-gradient(135deg, var(--bg-dark), var(--text-secondary));
                padding: 0.4rem 0.8rem;
                border-radius: 10px;
                color: white;
            }

            /* Tags */
            .tag-badge,
            .premium-tag,
            .premium-feature-tag {
                font-size: 0.6rem;
                padding: 0.2rem 0.4rem;
                border-radius: 10px;
                margin: 1px;
                font-weight: 500;
            }

            /* Player Count */
            .player-count,
            .premium-player-number,
            .premium-count-text {
                font-size: 0.95rem;
                font-weight: 700;
                color: var(--primary-green);
            }

            .premium-count-text {
                font-size: 1.5rem;
                font-weight: 900;
            }

            .premium-player-number {
                font-size: 1.3rem;
                font-weight: 800;
            }

            /* Copy Button */
            .copy-btn,
            .premium-copy-btn,
            .premium-copy-button {
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: var(--text-white);
                font-size: 0.75rem;
                padding: 0.2rem 0.4rem;
                border-radius: var(--border-radius-sm);
                backdrop-filter: blur(5px);
                transition: all 0.2s ease;
            }

            .copy-btn:hover,
            .premium-copy-btn:hover {
                background: var(--primary-blue);
                color: var(--text-white);
            }

            .premium-copy-button:hover {
                background: rgba(156, 39, 176, 0.8);
                color: white;
            }

            /* Logo Badges */
            .premium-logo-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--primary-gold), #ffed4e);
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.7rem;
                color: #1a1a2e;
            }

            /* Pulse Animation */
            .pulse,
            .premium-pulse,
            .premium-online-pulse {
                animation: pulse 2s ease-in-out infinite;
            }

            /* Server Listing Card */
            .server-listing-card {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 20px;
                margin-top: var(--spacing-xl);
            }

            /* Middle Description */
            .middle-description {
                background-color: var(--bg-dark);
                color: var(--text-white);
                border-radius: var(--border-radius-lg);
                margin: var(--spacing-lg) 0;
            }

            /* Mobile Server Cards */
            .mobile-server-card {
                background: white;
                border-radius: 15px;
                margin-bottom: 1rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                border: 2px solid var(--border-primary);
            }

            .mobile-server-header {
                background: linear-gradient(135deg, var(--bg-dark), var(--bg-darker));
                color: white;
                padding: 1rem;
            }

            .mobile-premium-header {
                background: linear-gradient(135deg, var(--primary-purple), #673ab7);
                color: white;
                padding: 1rem;
            }

            .mobile-top10-header {
                background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
                color: white;
                padding: 1rem;
                border-bottom: 2px solid var(--primary-gold);
            }

            .mobile-server-content {
                padding: 1rem;
            }

            .mobile-server-banner {
                width: 100%;
                height: 120px;
                border-radius: 10px;
                overflow: hidden;
                position: relative;
                margin-bottom: 1rem;
            }

            .mobile-server-banner img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .mobile-banner-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
                padding: 0.5rem;
                color: white;
            }

            .mobile-server-info {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .mobile-server-logo {
                width: 50px;
                height: 50px;
                border-radius: 8px;
                overflow: hidden;
                border: 2px solid var(--border-light);
                position: relative;
            }

            .mobile-server-logo img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .mobile-server-details h6 {
                margin: 0;
                font-weight: bold;
                color: var(--text-primary);
            }

            .mobile-server-stats {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .mobile-stat-item {
                text-align: center;
            }

            .mobile-stat-value {
                font-size: 1.2rem;
                font-weight: bold;
                color: var(--primary-green);
                display: block;
            }

            .mobile-stat-label {
                font-size: 0.8rem;
                color: var(--text-secondary);
            }

            .mobile-tags {
                display: flex;
                flex-wrap: wrap;
                gap: 0.25rem;
                margin-bottom: 1rem;
            }

            .mobile-actions {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            /* Dark Mode Adjustments */
            [data-bs-theme="dark"] .premium-top10-header {
                background: linear-gradient(135deg, #b8860b, #daa520, #b8860b);
            }

            [data-bs-theme="dark"] .premium-subtitle {
                color: #1a1a2e;
            }

            [data-bs-theme="dark"] .premium-top10-body {
                background: linear-gradient(135deg, var(--bg-secondary), var(--bg-dark));
            }

            [data-bs-theme="dark"] .premium-header {
                background: linear-gradient(135deg, var(--bg-secondary), var(--bg-dark));
                border-color: var(--primary-purple);
            }

            [data-bs-theme="dark"] .premium-section-subtitle {
                color: var(--text-secondary);
            }

            [data-bs-theme="dark"] .premium-body {
                background: linear-gradient(135deg, var(--bg-secondary), var(--bg-dark));
            }

            [data-bs-theme="dark"] .premium-server-row:hover {
                background: linear-gradient(135deg, var(--bg-dark), var(--text-secondary));
            }

            [data-bs-theme="dark"] .server-row:hover {
                background-color: var(--bg-dark);
            }

            [data-bs-theme="dark"] .middle-description {
                background-color: var(--bg-secondary);
            }

            [data-bs-theme="dark"] .mobile-server-card {
                background: var(--bg-secondary);
                border-color: var(--border-dark);
            }

            [data-bs-theme="dark"] .mobile-server-details h6 {
                color: var(--text-white);
            }

            /* Animations */
            @keyframes premiumGradient {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            @keyframes textShine {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }
            }

            .details-link {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                z-index: 1;
                background: transparent;
            }

            /* Responsive Design */
            @media (max-width: 992px) {

                /* Hide desktop table headers on tablet and mobile */
                .desktop-table-header {
                    display: none !important;
                }

                /* Show mobile cards on tablet and mobile */
                .desktop-server-row {
                    display: none !important;
                }

                .mobile-server-row {
                    display: block !important;
                }
            }

            @media (min-width: 993px) {

                /* Show desktop table on desktop */
                .desktop-table-header {
                    display: block !important;
                }

                .desktop-server-row {
                    display: block !important;
                }

                /* Hide mobile cards on desktop */
                .mobile-server-row {
                    display: none !important;
                }
            }

            @media (max-width: 768px) {

                /* Header adjustments */
                .minecraft-header img {
                    height: 120px;
                }

                .minecraft-header .px-5 {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }

                /* Welcome section */
                .welcome-section h1 {
                    font-size: 1.8rem;
                }

                .welcome-section .lead {
                    font-size: 1rem;
                }

                /* Premium headers */
                .premium-title {
                    font-size: 1.3rem;
                }

                .premium-section-title {
                    font-size: 1.2rem;
                }

                .premium-top10-header {
                    padding: 1.5rem 1rem;
                    margin-bottom: 1.5rem;
                }

                .premium-header {
                    padding: 1rem;
                    margin-bottom: 1.5rem;
                }

                /* Filter form - stack vertically on mobile */
                .filter_card .row.g-3>* {
                    margin-bottom: 0.5rem;
                }

                .filter_card .col-md-4,
                .filter_card .col-md-2,
                .filter_card .col-md-1 {
                    width: 100%;
                    max-width: none;
                }

                /* Mobile server cards spacing */
                .mobile-server-card {
                    margin-bottom: 1.5rem;
                }

                .mobile-server-banner {
                    height: 100px;
                }

                .mobile-server-logo {
                    width: 45px;
                    height: 45px;
                }

                .mobile-server-stats {
                    grid-template-columns: 1fr 1fr 1fr;
                    gap: 0.5rem;
                }

                .mobile-stat-value {
                    font-size: 1rem;
                }

                .mobile-stat-label {
                    font-size: 0.7rem;
                }

                /* Reduce spacing */
                .container.content {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }

                /* Card padding */
                .premium-top10-card-header,
                .premium-card-header,
                .server-card-header {
                    padding: 1rem;
                }

                .premium-top10-row,
                .premium-server-row,
                .server-row {
                    padding: 1rem 0.5rem;
                }

                /* Badge sizing */
                .tag-badge,
                .premium-tag,
                .premium-feature-tag {
                    font-size: 0.65rem;
                    padding: 0.15rem 0.3rem;
                    margin: 0.1rem;
                }

                /* Copy button sizing */
                .copy-btn,
                .premium-copy-btn,
                .premium-copy-button {
                    padding: 0.3rem 0.5rem;
                    font-size: 0.7rem;
                }

                /* Player count sizing */
                .premium-count-text {
                    font-size: 1.1rem;
                }

                .premium-player-number {
                    font-size: 1rem;
                }

                .player-count {
                    font-size: 0.9rem;
                }
            }

            @media (max-width: 480px) {

                /* Extra small screens */
                .welcome-section h1 {
                    font-size: 1.5rem;
                }

                .premium-title {
                    font-size: 1.1rem;
                }

                .premium-section-title {
                    font-size: 1rem;
                }

                .mobile-server-stats {
                    grid-template-columns: 1fr 1fr;
                }

                .mobile-server-banner {
                    height: 80px;
                }

                .mobile-server-logo {
                    width: 40px;
                    height: 40px;
                }

                .container.content {
                    margin-top: 1rem !important;
                    margin-bottom: 1rem !important;
                }

                .premium-top10-header,
                .premium-header {
                    padding: 1rem 0.75rem;
                }

                .mobile-banner-overlay {
                    padding: 0.25rem;
                }

                .mobile-server-content {
                    padding: 0.75rem;
                }
            }

            /* Landscape mobile adjustments */
            @media (max-width: 768px) and (orientation: landscape) {
                .minecraft-header img {
                    height: 80px;
                }

                .welcome-section {
                    margin-bottom: 1rem;
                }

                .premium-top10-header,
                .premium-header {
                    padding: 1rem;
                    margin-bottom: 1rem;
                }
            }

            /* Tablet specific adjustments */
            @media (min-width: 769px) and (max-width: 992px) {
                .mobile-server-banner {
                    height: 140px;
                }

                .mobile-server-logo {
                    width: 55px;
                    height: 55px;
                }

                .mobile-stat-value {
                    font-size: 1.3rem;
                }

                .mobile-server-stats {
                    grid-template-columns: 1fr 1fr 1fr;
                    gap: 1.5rem;
                }

                .premium-title {
                    font-size: 1.8rem;
                }

                .premium-section-title {
                    font-size: 1.5rem;
                }
            }
        </style>
    @endpush

    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('server-listing.user-dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Your Servers</li>
            </ol>
        </nav>

        <!-- Title -->
        <h1 class="page-title mb-4">Manage Your Servers</h1>

        <!-- Action Buttons -->
        <div class="mb-4 action-buttons">
            <button class="btn btn-warning text-white">
                <i class="bi bi-plus-lg"></i> Register a Server
            </button>
            {{-- <button class="btn btn-warning text-white">
                <i class="bi bi-bell"></i> Manage Notifications
            </button> --}}
            <button class="btn btn-warning text-white">
                <i class="bi bi-star-fill"></i> Premium Option
            </button>
        </div>

        <!-- Table -->
        @if (isset($sListings) && count($sListings) > 0)
            {{-- Popular Servers --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm server-card">
                        <div class="server-card-header desktop-table-header">
                            <div class="row align-items-center text-white">
                                <div class="col-md-2">
                                    <h5 class="mb-0 fw-bold"><i class="bi bi-hash text-white me-2"></i>{{ __('Rank') }}
                                    </h5>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-0 fw-bold"><i class="bi bi-server text-white me-2"></i>{{ __('Server') }}
                                    </h5>
                                </div>
                                <div class="col-md-2">
                                    <h5 class="mb-0 fw-bold text-center"><i
                                            class="bi bi-people text-white me-2"></i>{{ __('Players') }}</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5 class="mb-0 fw-bold text-center"><i
                                            class="bi bi-circle text-white me-2"></i>{{ __('Status') }}</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5 class="mb-0 fw-bold"><i class="bi bi-tags text-white me-2"></i>{{ __('Bidding') }}
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            @foreach ($sListings as $index => $sList)
                                <!-- Desktop Row -->
                                <div class="server-row desktop-server-row">
                                    <a href="{{ route('server-listing.details', $sList->slug) }}" class="details-link"></a>
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="d-flex align-items-center">
                                                <div class="server-logo me-3">
                                                    <img src="{{ $sList->logo_image_url }}" alt="Server Logo">
                                                </div>
                                                <div class="server-rank">
                                                    <div class="simple-server-badge">
                                                        <i class="bi bi-trophy text-white"></i>
                                                        <span class="fw-bold simple-server-text">#{{ $index + 3 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="server-banner">
                                                <img src="{{ $sList->banner_image_url }}" alt="Server Banner">
                                                <div class="banner-overlay">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge version-badge me-2">
                                                                <i
                                                                    class="bi bi-gear me-1"></i>{{ remove_before_dash($sList->minecraft_version) }}
                                                            </span>

                                                            <img style="height: 12px; width: 20px;" class="me-1"
                                                                src="https://flagcdn.com/{{ strtolower($sList?->country?->code) }}.svg"
                                                                alt="">

                                                            <span class="text-white text-decoration-none">
                                                                <small>{{ removeHttpFromUrl($sList->server_ip) }}</small>
                                                            </span>
                                                        </div>
                                                        <button class="btn btn-sm copy-btn"
                                                            onclick="copyIP('{{ $sList->server_ip }}')">
                                                            <i class="bi bi-copy"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="text-center">
                                                <span class="player-count">
                                                    {{ $sList->current_players }}/{{ $sList->max_players }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="text-center">
                                                <span class="badge status-badge {{ $sList->is_online ?: 'offline' }}">
                                                    <i
                                                        class=" me-1 {{ $sList->is_online ? 'pulse bi bi-circle-fill' : '' }}"></i>{{ __($sList->online_label) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" class="text-decoration-none text-white text-center">Bid Now</a>
                                            {{-- <div class="d-flex flex-wrap gap-1">
                                                @foreach ($sList->serverTags as $tag)
                                                    <span
                                                        class="badge tag-badge {{ Arr::random(tagsBgColors()) }} text-white">{{ $tag->name }}</span>
                                                @endforeach
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>

                                <!-- Mobile Card -->
                                <div class="mobile-server-row">
                                    <div class="mobile-server-card">
                                        <div class="mobile-server-header">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="simple-server-badge me-2">
                                                        <i class="bi bi-trophy text-white"></i>
                                                        <span class="fw-bold">#{{ $index + 3 }}</span>
                                                    </div>
                                                    <h6 class="mb-0 text-white">
                                                        <i class="bi bi-server me-1"></i>{{ __('Server') }}
                                                    </h6>
                                                </div>
                                                <span class="badge status-badge {{ $sList->is_online ?: 'offline' }}">
                                                    <i
                                                        class="me-1 {{ $sList->is_online ? 'pulse bi bi-circle-fill' : '' }}"></i>
                                                    {{ __($sList->online_label) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mobile-server-content">
                                            <a href="{{ route('server-listing.details', $sList->slug) }}"
                                                class="details-link"></a>

                                            <div class="mobile-server-banner">
                                                <img src="{{ $sList->banner_image_url }}" alt="Server Banner">
                                                <div class="mobile-banner-overlay">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge version-badge me-2">
                                                                <i
                                                                    class="bi bi-gear me-1"></i>{{ remove_before_dash($sList->minecraft_version) }}
                                                            </span>
                                                            <img style="height: 10px; width: 16px;" class="me-1"
                                                                src="https://flagcdn.com/{{ strtolower($sList?->country?->code) }}.svg"
                                                                alt="">
                                                        </div>
                                                        <button class="btn btn-sm copy-btn"
                                                            onclick="copyIP('{{ $sList->server_ip }}')">
                                                            <i class="bi bi-copy"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mobile-server-info">
                                                <div class="mobile-server-logo">
                                                    <img src="{{ $sList->logo_image_url }}" alt="Server Logo">
                                                </div>
                                                <div class="mobile-server-details flex-grow-1">
                                                    <h6>{{ removeHttpFromUrl($sList->server_ip) }}</h6>
                                                    <small class="text-muted">{{ __('Minecraft Server') }}</small>
                                                </div>
                                            </div>

                                            <div class="mobile-server-stats">
                                                <div class="mobile-stat-item">
                                                    <span
                                                        class="mobile-stat-value player-count">{{ $sList->current_players }}</span>
                                                    <small class="mobile-stat-label">{{ __('Online') }}</small>
                                                </div>
                                                <div class="mobile-stat-item">
                                                    <span
                                                        class="mobile-stat-value player-count">{{ $sList->max_players }}</span>
                                                    <small class="mobile-stat-label">{{ __('Max') }}</small>
                                                </div>
                                            </div>

                                            <div class="mobile-tags">
                                                @foreach ($sList->serverTags as $tag)
                                                    <span
                                                        class="badge tag-badge {{ Arr::random(tagsBgColors()) }} text-white">{{ $tag->name }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3">
                        {{ $sListings->appends(request()->except('popular_page'))->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="card server-card">
                <div class="card-body">
                    <div class="server-row">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h5 class="mb-0 fw-bold">{{ __('No servers found.') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
