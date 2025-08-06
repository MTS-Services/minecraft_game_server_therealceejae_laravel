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
        </style>
    @endpush

    <div class="minecraft-header position-relative overflow-hidden">
        <img src="https://placehold.co/1080x200/png?text=Minecraft+Landscape" alt="Minecraft Landscape" class="w-100">
        <div class="position-absolute top-0 start-0 w-100 h-100"></div>
    </div>
    <div class="container py-4">

        <div class="alert alert-info">
            <h5><i class="bis bi-info-circle me-2"></i>{{ trans('server-listing::messages.submission_card.requirements') }}
            </h5>
            <p class="mb-0">{{ trans('server-listing::messages.submission_card.requirement_text_regular') }}
                <strong>{{ trans('server-listing::messages.submission_card.requirement_text_strong') }}</strong>{{ trans('server-listing::messages.submission_card.requirement_text_regular2') }}
            </p>
        </div>

        <form id="addServerForm">
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
                        <label for="serverName"
                            class="form-label">{{ trans('server-listing::messages.fields.server_name') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="serverName" required
                            placeholder="{{ trans('server-listing::messages.placeholder.server_name') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="javaServerIP"
                            class="form-label">{{ trans('server-listing::messages.fields.java_server_ip') }}
                            <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="javaServerIP"
                            placeholder="{{ trans('server-listing::messages.placeholder.java_server_ip') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bedrockServerIP"
                            class="form-label">{{ trans('server-listing::messages.fields.bedrock_server_ip') }}</label>
                        <input type="text" class="form-control" id="bedrockServerIP"
                            placeholder="{{ trans('server-listing::messages.placeholder.bedrock_server_ip') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="websiteUrl"
                            class="form-label">{{ trans('server-listing::messages.fields.website_url') }}
                            <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" id="websiteUrl"
                            placeholder="{{ trans('server-listing::messages.placeholder.website_url') }}">
                    </div>
                </div>
                <div class="col mb-3">
                    <label for="description" class="form-label">{{ trans('server-listing::messages.fields.description') }}
                        <span class="text-danger">*</span></label>
                    <textarea class="form-control html-editor @error('description') is-invalid @enderror" id="textArea"
                        placeholder="{{ trans('server-listing::messages.placeholder.description') }}" name="description" rows="5">{{ old('description', $server->description ?? '') }}</textarea>

                    @error('description')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label for="country" class="form-label">{{ trans('server-listing::messages.fields.country') }}
                            <span class="text-danger">*</span></label>
                        <select class="form-select" id="country">
                            <option value="">{{ trans('server-listing::messages.fields.country-select') }}</option>
                            <option value="US">United States</option>
                            <option value="UK">United Kingdom</option>
                            <option value="DE">Germany</option>
                            <option value="FR">France</option>
                            <option value="CA">Canada</option>
                            <option value="AU">Australia</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="version"
                            class="form-label">{{ trans('server-listing::messages.fields.minecraft_version') }}<span
                                class="text-danger">*</span></label>
                        <select class="form-select" id="version">
                            <option value="">{{ trans('server-listing::messages.fields.minecraft_version_select') }}
                            </option>
                            <option value="1.20.2">1.20.2</option>
                            <option value="1.20.1">1.20.1</option>
                            <option value="1.19.4">1.19.4</option>
                            <option value="1.19.2">1.19.2</option>
                            <option value="1.18.2">1.18.2</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="discordUrl"
                            class="form-label">{{ trans('server-listing::messages.fields.discord_url') }}</label>
                        <input type="url" class="form-control" id="discordUrl"
                            placeholder="{{ trans('server-listing::messages.placeholder.discord_url') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="youtubeVideo"
                            class="form-label">{{ trans('server-listing::messages.fields.youtube_video') }}</label>
                        <input type="url" class="form-control" id="youtubeVideo"
                            placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="playerSlots"
                            class="form-label">{{ trans('server-listing::messages.fields.maximum_player_slots') }}</label>
                        <input type="number" class="form-control" id="playerSlots"
                            placeholder="{{ trans('server-listing::messages.placeholder.maximum_player_slots') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="supportEmail"
                            class="form-label">{{ trans('server-listing::messages.fields.support_email') }}</label>
                        <input type="email" class="form-control" id="supportEmail"
                            placeholder="{{ trans('server-listing::messages.placeholder.support_email') }}">
                    </div>
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
                    <div class="mb-4 col-md-6">
                        <label for="logoImageInput"
                            class="form-label">{{ trans('server-listing::messages.fields.logo_image') }}
                            <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('logo_image') is-invalid @enderror"
                            id="logoImageInput" name="logo_image" accept="image/jpg,image/jpeg,image/png,image/gif"
                            data-image-preview="logoImagePreview">
                        <div class="form-text">{{ trans('server-listing::messages.placeholder.logo_image_text') }}</div>

                        @error('logo_image')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <img src="#" class="mt-2 img-fluid rounded img-preview d-none" alt="logo image"
                            id="logoImagePreview">

                    </div>

                    <div class="mb-4 col-md-6">
                        <label for="bannerImageInput"
                            class="form-label">{{ trans('server-listing::messages.fields.banner_image') }}
                            <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('banner_image') is-invalid @enderror"
                            id="bannerImageInput" name="banner_image" accept="image/jpg,image/jpeg,image/png,image/gif"
                            data-image-preview="bannerImagePreview">
                        <div class="form-text">{{ trans('server-listing::messages.placeholder.banner_image_text') }}</div>

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

                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="survival"
                                value="survival">
                            <label class="tag-label" for="survival">Survival</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="creative"
                                value="creative">
                            <label class="tag-label" for="creative">Creative</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="hardcore"
                                value="hardcore">
                            <label class="tag-label" for="hardcore">Hardcore</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="adventure"
                                value="adventure">
                            <label class="tag-label" for="adventure">Adventure</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="spectator"
                                value="spectator">
                            <label class="tag-label" for="spectator">Spectator</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="factions"
                                value="factions">
                            <label class="tag-label" for="factions">Factions</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="skyblock"
                                value="skyblock">
                            <label class="tag-label" for="skyblock">SkyBlock</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="prison" value="prison">
                            <label class="tag-label" for="prison">Prison</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="towny" value="towny">
                            <label class="tag-label" for="towny">Towny</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="pvp" value="pvp">
                            <label class="tag-label" for="pvp">PvP</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="economy" value="economy">
                            <label class="tag-label" for="economy">Economy</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="ranks" value="ranks">
                            <label class="tag-label" for="ranks">Ranks</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="jobs" value="jobs">
                            <label class="tag-label" for="jobs">Jobs</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="quests" value="quests">
                            <label class="tag-label" for="quests">Quests</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="mcmmo" value="mcmmo">
                            <label class="tag-label" for="mcmmo">McMMO</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="vanilla" value="vanilla">
                            <label class="tag-label" for="vanilla">Vanilla</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="bukkit" value="bukkit">
                            <label class="tag-label" for="bukkit">Bukkit</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="spigot" value="spigot">
                            <label class="tag-label" for="spigot">Spigot</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="paper" value="paper">
                            <label class="tag-label" for="paper">Paper</label>
                        </div>
                        <div class="tag-item">
                            <input class="form-check-input tag-checkbox" type="checkbox" id="forge" value="forge">
                            <label class="tag-label" for="forge">Forge</label>
                        </div>

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
                            <input type="text" class="form-control" id="votifierHost"
                                placeholder="{{ trans('server-listing::messages.placeholder.votifier_host') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="votifierPort"
                                class="form-label">{{ trans('server-listing::messages.fields.votifier_port') }}</label>
                            <input type="number" class="form-control" id="votifierPort"
                                placeholder="{{ trans('server-listing::messages.placeholder.votifier_port') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="votifierKey"
                            class="form-label">{{ trans('server-listing::messages.fields.votifier_public_key') }}</label>
                        <textarea class="form-control" id="votifierKey" rows="3"
                            placeholder="{{ trans('server-listing::messages.placeholder.votifier_public_key') }}"></textarea>
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
                        <input type="text" class="form-control" id="teamspeakServer"
                            placeholder="{{ trans('server-listing::messages.placeholder.teamspeak_server_api_key') }}">
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

                    <div class="mb-3">
                        <label for="discordServer"
                            class="form-label">{{ trans('server-listing::messages.fields.discord_server_id') }}</label>
                        <input type="text" class="form-control" id="discordServer"
                            placeholder="{{ trans('server-listing::messages.placeholder.discord_server_id') }}">
                        <div class="form-text">{{ trans('server-listing::messages.placeholder.discord_server_id_text') }}
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
                        <input class="form-check-input" type="checkbox" id="hideVoters" required>
                        <label class="form-check-label" for="hideVoters">
                            Hide Top Voters
                        </label>

                    </div>
                    <div class="form-text">
                        <small><i class="bi bi-info-circle me-2"></i>This option allow you to hide the top voters list on
                            your vote page.</small>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="hidePlayer" required>
                        <label class="form-check-label" for="hidePlayer">
                            Hide Player List
                        </label>

                    </div>
                    <div class="form-text">
                        <small><i class="bi bi-info-circle me-2"></i>This option allow you to hide the player list on your
                            server page.</small>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="blockPing" required>
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
                        <input class="form-check-input" type="checkbox" id="blockVersionDetection" required>
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
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
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
