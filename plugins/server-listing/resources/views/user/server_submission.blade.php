@extends('layouts.base')
@section('title', trans('server-listing::messages.server_submission.title'))
@include('admin.elements.editor')
@section('app')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">

    @push('styles')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

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
                --spacing-md: .5rem;

                /* Border Radius */
                --border-radius-sm: 0.375rem;

                /* Shadows */
                --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                --shadow-lg: 1rem 3rem rgba(0, 0, 0, 0.175);

                /* Logo/Image Sizes */
                --logo-size-lg: 60px;
                --banner-height: 70px;
            }

            [data-bs-theme="dark"] {
                --bg-primary: #212529;
                --bg-secondary: #343a40;
                --text-primary: #ffffff;
                --text-secondary: #adb5bd;
                --border-light: #495057;
            }

            /* Minecraft Landscape Header */
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

            /* Form Sections */
            .form-section {
                background: var(--bg-primary);
                border-radius: 15px;
                padding: 2rem;
                margin-bottom: 2rem;
                box-shadow: var(--shadow-md);
                border: 1px solid var(--border-light);
            }

            .section-header {
                display: flex;
                align-items: center;
                margin-bottom: 1.5rem;
                padding-bottom: 1rem;
                border-bottom: 2px solid var(--border-light);
            }

            .section-icon {
                background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
                color: white;
                width: 40px;
                height: 40px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1rem;
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--text-primary);
                margin: 0;
            }

            /* Alert Styles */
            .alert-info {
                background: linear-gradient(45deg, rgba(33, 150, 243, 0.1), rgba(156, 39, 176, 0.1));
                border: 1px solid var(--primary-blue);
                border-radius: 12px;
                color: var(--text-primary);
            }

            .alert-warning {
                background: linear-gradient(45deg, rgba(255, 193, 7, 0.1), rgba(255, 152, 0, 0.1));
                border: 1px solid var(--status-warning);
                border-radius: 12px;
                color: var(--text-primary);
            }

            .alert-danger {
                background: linear-gradient(45deg, rgba(220, 53, 69, 0.1), rgba(255, 152, 0, 0.1));
                border: 1px solid var(--status-offline);
                border-radius: 12px;
                color: var(--text-primary);
            }

            /* Form Controls */
            .form-control,
            .form-select {
                border-radius: 10px;
                border: 2px solid var(--border-light);
                padding: 0.75rem 1rem;
                transition: all 0.3s ease;
                background: var(--bg-primary);
                color: var(--text-primary);
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--primary-blue);
                box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
                background: var(--bg-primary);
                color: var(--text-primary);
            }

            .form-label {
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 0.5rem;
            }

            .form-text {
                color: var(--text-secondary);
                font-size: 0.875rem;
            }

            /* Buttons */
            .btn-primary {
                background: linear-gradient(45deg, var(--primary-blue), var(--primary-purple));
                border: none;
                border-radius: 10px;
                padding: 0.75rem 1.5rem;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow-md);
                background: linear-gradient(45deg, var(--primary-purple), var(--primary-blue));
            }

            .btn-success {
                background: linear-gradient(45deg, var(--primary-green), var(--status-online));
                border: none;
                border-radius: 10px;
                padding: 0.75rem 1.5rem;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .btn-success:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow-md);
            }

            .btn-outline-primary {
                border: 2px solid var(--primary-blue);
                color: var(--primary-blue);
                border-radius: 10px;
                padding: 0.75rem 1.5rem;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .btn-outline-primary:hover {
                background: var(--primary-blue);
                transform: translateY(-1px);
            }

            /* Tag Selection Grid */
            .tag-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                margin-top: 1rem;
            }

            .tag-category {
                background: var(--bg-secondary);
                border-radius: 12px;
                padding: 1rem;
            }

            .tag-category h6 {
                color: var(--primary-blue);
                font-weight: 600;
                margin-bottom: 0.75rem;
                text-transform: uppercase;
                font-size: 0.875rem;
            }

            .tag-item {
                display: flex;
                align-items: center;
                margin-bottom: 0.5rem;
            }

            .tag-checkbox {
                margin-right: 0.5rem;
            }

            .tag-label {
                font-size: 0.875rem;
                color: var(--text-primary);
                cursor: pointer;
            }

            /* Verification Methods */
            .verification-method {
                border: 2px solid var(--border-light);
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 1rem;
                transition: all 0.3s ease;
            }

            .verification-method:hover {
                border-color: var(--primary-blue);
                background: var(--bg-secondary);
            }

            .verification-header {
                display: flex;
                align-items: center;
                margin-bottom: 1rem;
            }

            .verification-icon {
                width: 30px;
                height: 30px;
                margin-right: 1rem;
                color: var(--primary-blue);
            }

            .verification-title {
                font-weight: 600;
                color: var(--text-primary);
                margin: 0;
            }

            .verification-optional {
                background: var(--primary-gold);
                color: white;
                padding: 0.25rem 0.5rem;
                border-radius: 15px;
                font-size: 0.75rem;
                font-weight: 600;
                margin-left: auto;
            }

            /* Server Address Display */
            .server-address {
                background: var(--bg-secondary);
                border: 2px dashed var(--primary-blue);
                border-radius: 10px;
                padding: 1rem;
                text-align: center;
                font-family: 'Courier New', monospace;
                font-weight: 600;
                color: var(--primary-blue);
                margin: 1rem 0;
            }

            /* Footer */
            .footer {
                background: var(--bg-darker);
                color: var(--text-white);
                padding: 3rem 0 2rem;
                margin-top: 4rem;
            }

            .footer h6 {
                color: var(--primary-gold);
                font-weight: 700;
                text-transform: uppercase;
                margin-bottom: 1rem;
            }

            .footer a {
                color: var(--text-secondary);
                text-decoration: none;
                transition: all 0.3s ease;
            }

            .footer a:hover {
                color: var(--primary-blue);
            }

            .footer-bottom {
                border-top: 1px solid var(--border-dark);
                margin-top: 2rem;
                padding-top: 2rem;
                text-align: center;
                color: var(--text-secondary);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .tag-grid {
                    grid-template-columns: 1fr;
                }

                .page-title {
                    font-size: 2rem;
                }

                .form-section {
                    padding: 1.5rem;
                }
            }

            :root {
                --bs-font-sans-serif: 'Poppins', sans-serif;
                --bs-success: #28a745;
                --bs-danger: #dc3545;
                --bs-body-color: #212529;
                --bs-card-bg: #fff;
                --bs-border-color: #dee2e6;
                --bs-shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                --border-radius: 0.5rem;
                --bs-transition: all 0.3s ease;
            }

            [data-bs-theme="dark"] {
                --bs-body-color: #dee2e6;
                --bs-body-bg: #212529;
                --bs-card-bg: #292c31;
                --bs-border-color: #495057;
                --bs-shadow-sm: 0 0.125rem 0.25rem rgba(255, 255, 255, 0.05);
            }

            /* General Card Styling */
            .info-card {
                border-radius: var(--border-radius);
                transition: var(--bs-transition);
                border: 1px solid var(--bs-border-color);
                background-color: var(--bs-card-bg);
                box-shadow: var(--bs-shadow-sm);
            }

            .info-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            }

            .info-card .label {
                font-size: 0.8rem;
                font-weight: 500;
                color: var(--bs-secondary-color);
                margin-bottom: 0.25rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .info-card .value {
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--bs-body-color);
                line-height: 1.2;
            }

            .info-card-success {
                border-left: 5px solid var(--bs-success);
            }

            .info-card-error {
                border-left: 5px solid var(--bs-danger);
            }

            /* Server Logo Styling */
            .server-logo {
                width: 4rem;
                height: 4rem;
                object-fit: contain;
                border-radius: var(--border-radius);
                background: rgba(0, 0, 0, 0.05);
                padding: 0.5rem;
            }

            /* Status Alert Styling */
            .status-card {
                border-radius: var(--border-radius);
            }

            .status-card .card-body {
                padding: 1.5rem;
            }

            .status-card .card-title {
                font-weight: 600;
            }

            .status-icon {
                width: 2.5rem;
                height: 2.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                font-size: 1.5rem;
            }

            .card-note {
                font-size: 0.8rem;
                font-weight: 500;
                color: var(--bs-secondary-color);
                margin-top: 1rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .card-note-info {
                display: flex;
                flex-direction: column;
                gap: 0.2rem;
                margin-top: 0.5rem;
                background: #dc354547;
                padding: 1rem;
                border-radius: 10px;
                color: #020;
                font-weight: 400;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
        <script>
            // Snippet from @thierryc on GitHub
            // https://gist.github.com/codeguy/6684588?permalink_comment_id=3243980#gistcomment-3243980
            function slugifyInput(str) {
                return str
                    .normalize(
                        'NFKD'
                    ) // The normalize() using NFKD method returns the Unicode Normalization Form of a given string.
                    .toLowerCase() // Convert the string to lowercase letters
                    .trim() // Remove whitespace from both sides of a string (optional)
                    .replace(/\s+/g, '-') // Replace spaces with -
                    .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                    .replace(/--+/g, '-'); // Replace multiple - with single -
            }

            function generateSlug() {
                const name = document.getElementById('serverName').value;
                document.getElementById('serverSlug').value = slugifyInput(name);
            }
        </script>
    @endpush

    @push('footer-scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const serverIpInput = document.getElementById('serverIpInput');
                const serverPortInput = document.getElementById('serverPortInput');
                const checkConnectionButton = document.querySelector('.btn-group .btn-primary');

                // Status Elements
                const statusSection = document.getElementById('connectionStatusSection');
                const successCard = document.getElementById('successCard');
                const errorCard = document.getElementById('errorCard');
                const successMessage = document.getElementById('successMessage');
                const errorMessage = document.getElementById('errorMessage');
                const serverDetailsContainer = document.getElementById('serverDetailsContainer');
                const serverBedrockSupportedValue = document.getElementById('serverBedrockSupportedValue');
                const playersOnlineValue = document.getElementById('playersOnlineValue');
                const serverVersionValue = document.getElementById('serverVersionValue');
                const serverLogoPreview = document.getElementById('serverLogoPreview');

                function toggleButtonState() {
                    if (serverIpInput.value.trim() === '') {
                        checkConnectionButton.disabled = true;
                    } else {
                        checkConnectionButton.disabled = false;
                    }
                }
                toggleButtonState();
                serverIpInput.addEventListener('input', toggleButtonState);

                checkConnectionButton.addEventListener('click', function() {
                    // Show loading state and hide previous messages
                    checkConnectionButton.disabled = true;
                    checkConnectionButton.innerHTML =
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking...`;
                    statusSection.classList.add('d-none');
                    successCard.classList.add('d-none');
                    errorCard.classList.add('d-none');
                    serverDetailsContainer.classList.add('d-none');

                    const serverIp = serverIpInput.value;
                    const serverPort = serverPortInput.value;

                    axios.post("{{ route('server-listing.check-connection') }}", {
                            serverIp: serverIp,
                            serverPort: serverPort
                        })
                        .then(function(response) {
                            const data = response.data;
                            statusSection.classList.remove('d-none');

                            if (data.success) {
                                // Connection is successful
                                successCard.classList.remove('d-none');
                                successMessage.innerText = data.message;
                                serverDetailsContainer.classList.remove('d-none');

                                // Update server details
                                const serverData = data.server_data;
                                // serverBedrockSupportedValue.innerHTML = serverData.motd.clean.join('<br>');
                                serverBedrockSupportedValue.innerHTML = serverData.debug.bedrock ? 'Yes' :
                                    'No';
                                playersOnlineValue.innerText =
                                    `${serverData.players.online} / ${serverData.players.max}`;
                                serverVersionValue.innerText = serverData.protocol.name;

                                // Update server logo
                                if (serverData.icon) {
                                    serverLogoPreview.src = `{{ base64_encode('') }}${serverData.icon}`;
                                    serverLogoPreview.classList.remove('d-none');
                                } else {
                                    serverLogoPreview.classList.add('d-none');
                                }

                            } else {
                                // Connection failed for various reasons
                                errorCard.classList.remove('d-none');
                                errorMessage.innerText = data.message;
                            }
                        })
                        .catch(function(error) {
                            statusSection.classList.remove('d-none');
                            errorCard.classList.remove('d-none');

                            // Handle the two different error types from the controller
                            if (error.response && error.response.status === 400) {
                                // This is for invalid input (e.g., empty IP)
                                errorMessage.innerText = error.response.data.message;
                            } else if (error.response && error.response.data && error.response.data
                                .message) {
                                // This is for the "offline" reason from the API
                                errorMessage.innerText = error.response.data.message;
                            } else {
                                // A generic network or server error
                                errorMessage.innerText = 'An unexpected error occurred. Please try again.';
                            }
                        })
                        .finally(function() {
                            checkConnectionButton.disabled = false;
                            checkConnectionButton.innerHTML = 'Check Connection';
                        });
                });
            });
        </script>
    @endpush
    <div class="container py-4">

        <div class="alert alert-info">
            <h5><i class="bis bi-info-circle me-2"></i>{{ trans('server-listing::messages.submission_card.requirements') }}
            </h5>
            <p class="mb-0">{{ trans('server-listing::messages.submission_card.requirement_text_regular') }}
                <strong>{{ trans('server-listing::messages.submission_card.requirement_text_strong') }}</strong>{{ trans('server-listing::messages.submission_card.requirement_text_regular2') }}
            </p>
        </div>

        <div id="connectionStatusSection" class="col-12 mb-3 d-none">
            {{-- Success Message Card (Initially Hidden) --}}
            <div id="successCard" class="card mb-3 status-card border-success shadow-sm d-none">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="status-icon bg-success-subtle text-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">{{ trans('server-listing::messages.server_connection.success') }}</h5>
                        <p class="mb-0 text-success" id="successMessage"></p>
                    </div>
                </div>
            </div>

            {{-- Error Message Card (Initially Hidden) --}}
            <div id="errorCard" class="card mb-3 status-card border-danger shadow-sm d-none">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="status-icon bg-danger-subtle text-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-0">{{ trans('server-listing::messages.server_connection.failed') }}</h5>
                        <p class="mb-0 text-danger" id="errorMessage"></p>
                    </div>
                </div>
            </div>

            {{-- Server Details Container (Initially Hidden) --}}
            <div id="serverDetailsContainer" class="row gx-3 d-none">
                <div class="col-md-3">
                    <div class="info-card h-100 p-3 text-center">
                        <img id="serverLogoPreview" src="#" alt="Server Logo" class="server-logo d-none">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card info-card-success h-100 p-3">
                        <p class="label">{{ trans('server-listing::messages.server_connection.supported') }}</p>
                        <p class="value" id="serverBedrockSupportedValue">
                            {{ trans('server-listing::messages.server_connection.unknown') }}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card info-card-success h-100 p-3">
                        <p class="label">{{ trans('server-listing::messages.server_connection.players') }}</p>
                        <p class="value" id="playersOnlineValue">
                            {{ trans('server-listing::messages.server_connection.unknown') }}</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card info-card-success h-100 p-3">
                        <p class="label">{{ trans('server-listing::messages.server_connection.version') }}</p>
                        <p class="value" id="serverVersionValue">
                            {{ trans('server-listing::messages.server_connection.unknown') }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="alert alert-danger">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('server-listing.submission.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-server"></i>
                    </div>
                    <h3 class="section-title">{{ trans('server-listing::messages.submission_card.server_info') }}</h3>
                </div>

                <div class="alert alert-warning">
                    <small><i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>{{ trans('server-listing::messages.submission_card.notice') }}:</strong>
                        {{ trans('server-listing::messages.submission_card.notice_text') }}
                    </small>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="serverIpInput"
                            class="form-label">{{ trans('server-listing::messages.fields.server_ip') }}
                            <span class="text-danger">*</span></label>
                        <input name="server_ip" type="text" class="form-control" value="{{ old('server_ip') }}"
                            id="serverIpInput" placeholder="{{ trans('server-listing::messages.placeholder.server_ip') }}"
                            required>

                        @error('server_ip')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="serverPortInput"
                            class="form-label">{{ trans('server-listing::messages.fields.server_port') }}</label>
                        <div class="btn-group w-100">
                            <input name="server_port" value="{{ old('server_port') }}" type="number" class="form-control"
                                style="border-radius: 10px 0 0 10px" id="serverPortInput"
                                placeholder="{{ trans('server-listing::messages.placeholder.server_port') }}">
                            <button class="btn btn-primary text-nowrap" type="button">Check Connection</button>
                        </div>
                        @error('server_port')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="serverName"
                            class="form-label">{{ trans('server-listing::messages.fields.server_name') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                            id="serverName" required
                            placeholder="{{ trans('server-listing::messages.placeholder.server_name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="serverSlug" class="form-label">Slug<span class="text-danger">*</span></label>
                        <div class="btn-group w-100">
                            <input type="text" name="slug" value="{{ old('slug') }}" class="form-control"
                                style="border-radius: 10px 0 0 10px" id="serverSlug" required
                                placeholder="{{ trans('server-listing::messages.placeholder.server_name') }}">
                            <button class="btn btn-primary text-nowrap" type="button"
                                onclick="generateSlug()">Generate</button>
                        </div>
                        @error('slug')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="col mb-3">
                    <label for="description"
                        class="form-label">{{ trans('server-listing::messages.fields.description') }}
                        <span class="text-danger">*</span></label>
                    <textarea class="form-control html-editor @error('description') is-invalid @enderror" id="textArea"
                        placeholder="{{ trans('server-listing::messages.placeholder.description') }}" name="description" rows="5">{{ old('description', $server->description ?? '') }}</textarea>

                    @error('description')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <!-- Additional Information Section -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-tags"></i>
                    </div>
                    <h3 class="section-title">{{ trans('server-listing::messages.additional_info') }}</h3>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="websiteUrl"
                            class="form-label">{{ trans('server-listing::messages.fields.website_url') }}
                            <span class="text-danger">*</span></label>
                        <input type="url" name="website_url" value="{{ old('website_url') }}" required
                            class="form-control" id="websiteUrl"
                            placeholder="{{ trans('server-listing::messages.placeholder.website_url') }}">
                        @error('website_url')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="youtubeVideo"
                            class="form-label">{{ trans('server-listing::messages.fields.youtube_video') }}</label>
                        <input type="url" name="youtube_video" value="{{ old('youtube_video') }}"
                            class="form-control" id="youtubeVideo" placeholder="https://www.youtube.com/watch?v=...">
                        @error('youtube_video')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="supportEmail"
                            class="form-label">{{ trans('server-listing::messages.fields.support_email') }}</label>
                        <input type="email" name="support_email" value="{{ old('support_email') }}"
                            class="form-control" id="supportEmail"
                            placeholder="{{ trans('server-listing::messages.placeholder.support_email') }}">
                        @error('support_email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-4 col">
                        <label for="bannerImageInput"
                            class="form-label">{{ trans('server-listing::messages.fields.banner_image') }}
                            <span class="text-danger">*</span></label>
                        <input type="file" name="banner_image" value="{{ old('banner_image') }}"
                            class="form-control @error('banner_image') is-invalid @enderror" id="bannerImageInput"
                            name="banner_image" accept="image/jpg,image/jpeg,image/png,image/gif"
                            data-image-preview="bannerImagePreview">
                        <div class="form-text">{{ trans('server-listing::messages.placeholder.banner_image_text') }}
                        </div>

                        @error('banner_image')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <img src="#" class="mt-2 img-fluid rounded img-preview d-none" alt="banner image"
                            id="bannerImagePreview">

                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">{{ trans('server-listing::messages.fields.tags') }} <span
                            class="text-danger">*</span></label>
                    <div class="form-text mb-3">{{ trans('server-listing::messages.placeholder.tags_text') }}</div>

                    <div class="tag-grid tag-category">

                        @forelse($tags as $tag)
                            <div class="tag-item">
                                <input class="form-check-input tag-checkbox" type="checkbox" name="tags[]"
                                    value="{{ $tag->id }}" id="tag_{{ $tag->slug }}"
                                    value="{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                <label class="tag-label" for="tag_{{ $tag->slug }}">{{ $tag->name }}</label>
                            </div>
                        @empty
                            <p class="text-muted">No game modes / tags available</p>
                        @endforelse
                        @error('tags')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                    </div>
                </div>

                <div class="alert alert-warning">
                    <small><i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>{{ trans('server-listing::messages.warning') }}:</strong>
                        {{ trans('server-listing::messages.placeholder.tags_warning') }}
                    </small>
                </div>
            </div>

            <!-- Votifier Section -->
            <div class="form-section">
                <div class="verification-method">
                    <div class="verification-header">
                        <div class="section-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="verification-title">{{ trans('server-listing::messages.submission_card.votifier') }}
                        </h4>
                        <span class="verification-optional">{{ trans('server-listing::messages.fields.optional') }}</span>
                    </div>
                    <p class="text-muted">{{ trans('server-listing::messages.submission_card.votifier_text') }}</p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="votifierHost"
                                class="form-label">{{ trans('server-listing::messages.fields.votifier_host') }}</label>
                            <input type="text" name="votifier_host" value="{{ old('votifier_host') }}"
                                class="form-control" id="votifierHost"
                                placeholder="{{ trans('server-listing::messages.placeholder.votifier_host') }}">
                            @error('votifier_host')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="votifierPort"
                                class="form-label">{{ trans('server-listing::messages.fields.votifier_port') }}</label>
                            <input type="number" name="votifier_port" value="{{ old('votifier_port') }}"
                                class="form-control" id="votifierPort"
                                placeholder="{{ trans('server-listing::messages.placeholder.votifier_port') }}">
                            @error('votifier_port')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="votifierKey"
                            class="form-label">{{ trans('server-listing::messages.fields.votifier_public_key') }}</label>
                        <textarea class="form-control" name="votifier_public_key" id="votifierKey" rows="3"
                            placeholder="{{ trans('server-listing::messages.placeholder.votifier_public_key') }}">{{ old('votifier_public_key', $server->votifier_public_key ?? '') }}</textarea>
                        @error('votifier_public_key')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- TeamSpeak Section -->
            <div class="form-section">
                <div class="verification-method">
                    <div class="verification-header">
                        <div class="section-icon">
                            <i class="bi bi-people"></i>
                        </div>

                        <h4 class="verification-title">{{ trans('server-listing::messages.submission_card.teamspeak') }}
                        </h4>
                        <span class="verification-optional">{{ trans('server-listing::messages.fields.optional') }}</span>
                    </div>

                    <div class="mb-3">
                        <label for="teamspeakServer"
                            class="form-label">{{ trans('server-listing::messages.fields.teamspeak_server_api_key') }}</label>
                        <input type="text" name="teamspeak_server_api_key"
                            value="{{ old('teamspeak_server_api_key') }}" class="form-control" id="teamspeakServer"
                            placeholder="{{ trans('server-listing::messages.placeholder.teamspeak_server_api_key') }}">
                        @error('teamspeak_server_api_key')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <div class="form-text">
                            {{ trans('server-listing::messages.placeholder.teamspeak_server_api_key_text') }}</div>
                    </div>

                    {{-- <div class="server-address">
                        Verification Code: TS-MC-VERIFY-2025
                    </div> --}}
                </div>
            </div>

            <!-- Discord Section -->
            <div class="form-section">
                <div class="verification-method">
                    <div class="verification-header">
                        <div class="section-icon">
                            <i class="bi bi-discord"></i>
                        </div>
                        <h4 class="verification-title">{{ trans('server-listing::messages.discord') }}</h4>
                        <span class="verification-optional">{{ trans('server-listing::messages.fields.optional') }}</span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="discordUrl"
                                class="form-label">{{ trans('server-listing::messages.fields.discord_url') }}</label>
                            <input type="url" name="discord_url" value="{{ old('discord_url') }}"
                                class="form-control" id="discordUrl"
                                placeholder="{{ trans('server-listing::messages.placeholder.discord_url') }}">
                            @error('discord_url')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="discordServer"
                                class="form-label">{{ trans('server-listing::messages.fields.discord_server_id') }}</label>
                            <input type="text" name="discord_server_id" value="{{ old('discord_server_id') }}"
                                class="form-control" id="discordServer"
                                placeholder="{{ trans('server-listing::messages.placeholder.discord_server_id') }}">
                            @error('discord_server_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col">
                            <div class="form-text">
                                {{ trans('server-listing::messages.placeholder.discord_server_id_text') }}
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <small><i class="fab fa-discord me-2"></i>
                            {{ trans('server-listing::messages.placeholder.discord_server_id_instractions') }}
                        </small>
                    </div>
                </div>
            </div>



            <!-- Additional Settings Section -->
            <div class="form-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <h3 class="section-title">{{ trans('server-listing::messages.additional_settings') }}</h3>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" name="hide_voters" value="1"
                            {{ old('hide_voters') ? 'checked' : '' }} type="checkbox" id="hideVoters">
                        <label class="form-check-label" for="hideVoters">
                            Hide Top Voters
                        </label>
                        @error('hide_voters')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                    </div>
                    <div class="form-text">
                        <small><i class="bi bi-info-circle me-2"></i>This option allow you to hide the top voters list on
                            your vote page.</small>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" name="hide_players_list" value="1"
                            {{ old('hide_players_list') ? 'checked' : '' }} type="checkbox" id="hidePlayer">
                        <label class="form-check-label" for="hidePlayer">
                            Hide Player List
                        </label>
                        @error('hide_players_list')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-text">
                        <small><i class="bi bi-info-circle me-2"></i>This option allow you to hide the player list on your
                            server page.</small>
                    </div>
                </div>
                {{-- <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="blockPing">
                        <label class="form-check-label" for="blockPing">
                            Block Ping
                        </label>

                    </div>
                    <div class="form-text">
                        <small><i class="bi bi-info-circle me-2"></i>Select this option if you don't want to allow us to
                            measure the latency (ICMP protocol) of your server.</small>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="blockVersionDetection">
                        <label class="form-check-label" for="blockVersionDetection">
                            Block Version Detection
                        </label>

                    </div>
                    <div class="form-text">
                        <small><i class="bi bi-info-circle me-2"></i>Select this option if you want to force a version for
                            your server. This will disabled the automatic version detection.</small>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="premiumListing">
                        <label class="form-check-label" for="premiumListing">
                            <strong>{{ trans('server-listing::messages.premium_listing') }}</strong>
                            {{ trans('server-listing::messages.premium_listing_text') }}
                        </label>
                    </div>
                    <div class="form-text">{{ trans('server-listing::messages.premium_listing_text2') }}</div>
                </div> --}}

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" name="terms_accepted" type="checkbox" id="agreeTerms"
                            {{ old('terms_accepted') ? 'checked' : '' }} value="1" required>
                        @error('terms_accepted')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <label class="form-check-label" for="agreeTerms">
                            I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a
                                href="#" class="text-decoration-none">Community Guidelines</a> *
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="form-section text-center">
                <div class="mb-4">
                    <h4 class="text-primary mb-3">Ready to Submit?</h4>
                    <p class="text-muted">Review your information and submit your server for review. Our team will
                        verify your server within 24-48 hours.</p>
                </div>

                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>
                        {{ trans('server-listing::messages.actions.submit_server') }}
                    </button>
                </div>

                <div class="mt-4">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        By submitting your server, you confirm that all information is accurate and that you own or have
                        permission to list this server.
                    </small>
                </div>
            </div>
        </form>

    </div>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6>Top Servers</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Best Survival</a></li>
                        <li><a href="#">Top Creative</a></li>
                        <li><a href="#">Popular PvP</a></li>
                        <li><a href="#">Faction Wars</a></li>
                        <li><a href="#">SkyBlock</a></li>
                        <li><a href="#">Mini Games</a></li>
                        <li><a href="#">Roleplay</a></li>
                        <li><a href="#">Hardcore</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6>Top Cities</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">San Francisco</a></li>
                        <li><a href="#">New York</a></li>
                        <li><a href="#">Los Angeles</a></li>
                        <li><a href="#">Chicago</a></li>
                        <li><a href="#">Seattle</a></li>
                        <li><a href="#">Miami</a></li>
                        <li><a href="#">Dallas</a></li>
                        <li><a href="#">Atlanta</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6>Top Countries</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">United States & America</a></li>
                        <li><a href="#">United Kingdom</a></li>
                        <li><a href="#">Germany</a></li>
                        <li><a href="#">France</a></li>
                        <li><a href="#">Canada</a></li>
                        <li><a href="#">Australia</a></li>
                        <li><a href="#">Netherlands</a></li>
                        <li><a href="#">Sweden</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6>Our Sites</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">API Documentation</a></li>
                    </ul>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-6 mb-3">
                    <h6>Premium Servers</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">HyperCraft Network - Ultimate Survival Experience</a></li>
                        <li><a href="#">MegaCraft Hub - Premium Minigames Server</a></li>
                        <li><a href="#">PixelWorld Adventures - Best Pixelmon Server</a></li>
                        <li><a href="#">CraftWars PvP - Hardcore Faction Battles</a></li>
                        <li><a href="#">SkyBlock Paradise with Custom Islands and more</a></li>
                    </ul>
                </div>
                <div class="col-lg-6 mb-3">
                    <h6>Latest Reviews</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">"Amazing server with friendly community!"</a></li>
                        <li><a href="#">"Best survival server I've ever played on"</a></li>
                        <li><a href="#">"Great custom plugins and active staff"</a></li>
                        <li><a href="#">"Perfect for both beginners and pros"</a></li>
                        <li><a href="#">"Unique features that keep me coming back"</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; 2025 Minecraft-MP.com. All Rights Reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">Powered by <strong>Azuriom</strong></p>
                        <div class="mt-2">
                            <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="me-3"><i class="fab fa-discord"></i></a>
                            <a href="#" class="me-3"><i class="fab fa-github"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

@endsection
