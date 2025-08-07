{{-- <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

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
</style> --}}

@include('server-listing::admin.elements.select')

@include('admin.elements.editor')

<div>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
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

<div class="card mb-3">
    <div class="card-header d-flex align-items-center">
        <i class="bi bi-info-circle-fill me-2"></i>
        <strong>{{ trans('server-listing::messages.submission_card.server_info') }}</strong>
    </div>
    <div class="card-body">
        <div class="row gx-3">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="serverIpInput">{{ trans('server-listing::messages.fields.server_ip') }}
                    <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('server_ip') is-invalid @enderror" id="serverIpInput"
                    name="server_ip" required
                    placeholder="{{ trans('server-listing::messages.placeholder.server_ip') }}"
                    value="{{ old('server_ip', $server->server_ip ?? '') }}">
                @error('server_ip')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label"
                    for="serverPortInput">{{ trans('server-listing::messages.fields.server_port') }}</label>
                <div class="btn-group w-100">
                    <input type="text" class="form-control @error('server_port') is-invalid @enderror"
                        id="serverPortInput" name="server_port"
                        placeholder="{{ trans('server-listing::messages.placeholder.server_port') }}"
                        value="{{ old('server_port', $server->server_port ?? '') }}">
                    <button class="btn btn-primary text-nowrap" type="button">Check Connection</button>
                </div>
                @error('server_port')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror

            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label" for="userSelect">{{ trans('server-listing::messages.fields.user') }} <span
                        class="text-danger">*</span></label>
                <select class="form-select @error('user_id') is-invalid @enderror" id="userSelect" name="user_id"
                    required>
                    <option value="" hidden selected>{{ trans('server-listing::messages.fields.user-select') }}
                    </option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id', $server->user_id ?? '') == $user->id)>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label" for="nameInput">{{ trans('server-listing::messages.fields.name') }} <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput"
                    name="name" value="{{ old('name', $server->name ?? '') }}" required
                    placeholder="{{ trans('server-listing::messages.placeholder.name') }}">
                @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label" for="slugInput">{{ trans('server-listing::messages.fields.slug') }} <span
                        class="text-danger">*</span></label>
                <div class="input-group @error('slug') has-validation @enderror">
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slugInput"
                        name="slug" value="{{ old('slug', $server->slug ?? '') }}" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                    @error('slug')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="websiteUrlInput" class="form-label">
                    {{ trans('server-listing::messages.fields.website_url') }}
                </label>
                <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                    id="websiteUrlInput" name="website_url"
                    placeholder="{{ trans('server-listing::messages.placeholder.website_url') }}"
                    value="{{ old('website_url', $server->website_url ?? '') }}">
                @error('website_url')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="discordUrlInput"
                    class="form-label">{{ trans('server-listing::messages.fields.discord_url') }}</label>
                <input type="url" class="form-control @error('discord_url') is-invalid @enderror"
                    id="discordUrlInput" name="discord_url"
                    placeholder="{{ trans('server-listing::messages.placeholder.discord_url') }}"
                    value="{{ old('discord_url', $server->discord_url ?? '') }}">
                @error('discord_url')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="youtubeVideoInput"
                    class="form-label">{{ trans('server-listing::messages.fields.youtube_video') }}</label>
                <input type="url" class="form-control @error('youtube_video') is-invalid @enderror"
                    id="youtubeVideoInput" name="youtube_video"
                    placeholder="{{ trans('server-listing::messages.placeholder.youtube_video') }}"
                    value="{{ old('youtube_video', $server->youtube_video ?? '') }}">
                @error('youtube_video')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="supportEmailInput"
                    class="form-label">{{ trans('server-listing::messages.fields.support_email') }}</label>
                <input type="email" class="form-control @error('support_email') is-invalid @enderror"
                    id="supportEmailInput" name="support_email"
                    placeholder="{{ trans('server-listing::messages.placeholder.support_email') }}"
                    value="{{ old('support_email', $server->support_email ?? '') }}">
                @error('support_email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label" for="descriptionInput">
                    {{ trans('server-listing::messages.fields.description') }}
                    <span class="text-danger">*</span>
                </label>
                <textarea class="form-control html-editor @error('description') is-invalid @enderror" id="descriptionInput"
                    placeholder="{{ trans('server-listing::messages.placeholder.description') }}" name="description" rows="5">{{ old('description', $server->description ?? '') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header d-flex align-items-center">
        <i class="bi bi-tags me-2"></i>
        <strong>{{ trans('server-listing::messages.additional_info') }}</strong>
    </div>
    <div class="card-body">
        <div class="row gx-3">
            <div class="col-md-4 mb-3">
                <label for="discordServerIdInput"
                    class="form-label">{{ trans('server-listing::messages.fields.discord_server_id') }}</label>
                <input type="url" class="form-control @error('discord_server_id') is-invalid @enderror"
                    id="discordServerIdInput" name="discord_server_id"
                    placeholder="{{ trans('server-listing::messages.placeholder.discord_server_id') }}"
                    value="{{ old('discord_server_id', $server->discord_server_id ?? '') }}">
                @error('discord_server_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>


            <div class="col-md-4 mb-3">
                <label for="tagsInput" class="form-label">{{ trans('server-listing::messages.fields.tags') }} <span
                        class="text-danger">*</span></label>
                <select class="form-select @error('tags') is-invalid @enderror" id="tagsInput" name="tags[]"
                    required multiple>
                    <option value="" hidden selected>{{ trans('server-listing::messages.fields.tags-select') }}
                    </option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags', isset($server->serverTags) ? $server->serverTags->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
                @error('tags')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                @foreach ($errors->get('tags.*') as $tagErrors)
                    @foreach ($tagErrors as $message)
                        <span class="invalid-feedback d-block"
                            role="alert"><strong>{{ $message }}</strong></span>
                    @endforeach
                @endforeach
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label"
                    for="isFeaturedSwitch">{{ trans('server-listing::messages.fields.is_featured') }}</label>
                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input @error('is_featured_limit') is-invalid @enderror"
                        id="isFeaturedSwitch" name="is_featured" @checked(old('is_featured', $server->is_featured ?? false))>
                    <label class="form-check-label"
                        for="isFeaturedSwitch">{{ trans('server-listing::messages.fields.make_featured') }}</label>
                </div>
                @error('is_featured_limit')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label"
                    for="isPremiumSwitch">{{ trans('server-listing::messages.fields.is_premium') }}</label>
                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="isFeaturedSwitch" name="is_premium"
                        @checked(old('is_premium', $server->is_premium ?? false))>
                    <label class="form-check-label"
                        for="isPremiumSwitch">{{ trans('server-listing::messages.fields.make_premium') }}</label>
                </div>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label"
                    for="teamSpeakServerApi">{{ trans('server-listing::messages.fields.teamspeak_server_api_key') }}</label>
                <input type="text" class="form-control @error('teamspeak_server_api_key') is-invalid @enderror"
                    id="teamSpeakServerApi" name="teamspeak_server_api_key"
                    placeholder="{{ trans('server-listing::messages.placeholder.teamspeak_server_api_key') }}"
                    value="{{ old('teamspeak_server_api_key', $server->teamspeak_server_api_key ?? '') }}">
                @error('teamspeak_server_api_key')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label"
                    for="isApprovedSwitch">{{ trans('server-listing::messages.fields.is_approved') }}</label>
                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="isApprovedSwitch" name="is_approved"
                        @checked(old('is_approved', $server->is_approved ?? false))>
                    <label class="form-check-label"
                        for="isPremiumSwitch">{{ trans('server-listing::messages.fields.make_approved') }}</label>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label"
                    for="isOnlineSwitch">{{ trans('server-listing::messages.fields.is_online') }}</label>
                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="isOnlineSwitch" name="is_online"
                        @checked(old('is_online', $server->is_online ?? false))>
                    <label class="form-check-label"
                        for="isPremiumSwitch">{{ trans('server-listing::messages.fields.make_online') }}</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label"
                    for="bannerImageInput">{{ trans('server-listing::messages.fields.banner_image') }} <span
                        class="text-danger">*</span></label>
                <input type="file" class="form-control @error('banner_image') is-invalid @enderror" required
                    id="bannerImageInput" name="banner_image" accept="image/jpg,image/jpeg,image/png,image/gif"
                    data-image-preview="bannerImagePreview">
                @error('banner_image')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                <img src="{{ isset($server->banner_image_url) ? $server->banner_image_url : '#' }}"
                    class="mt-2 img-fluid rounded img-preview {{ isset($server->banner_image_url) ? '' : 'd-none' }}"
                    alt="banner image" id="bannerImagePreview">
            </div>           

        </div>
    </div>
</div>


<div class="card mb-3">
    <div class="card-header d-flex align-items-center">
        <i class="bi bi-shield-check me-2"></i>
        <strong>{{ trans('server-listing::messages.submission_card.votifier') }}</strong>
    </div>
    <div class="card-body">
        <div class="row gx-3">
            <div class="col-md-6 mb-3">
                <label class="form-label"
                    for="votifierHost">{{ trans('server-listing::messages.fields.votifier_host') }}</label>
                <input type="url" class="form-control @error('votifier_host') is-invalid @enderror"
                    id="votifierHost" name="votifier_host"
                    placeholder="{{ trans('server-listing::messages.placeholder.votifier_host') }}"
                    value="{{ old('votifier_host', $server->votifier_host ?? '') }}">
                @error('votifier_host')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label"
                    for="votifierPortInput">{{ trans('server-listing::messages.fields.votifier_port') }}</label>
                <input type="number" class="form-control @error('votifier_port') is-invalid @enderror"
                    id="votifierPortInput" name="votifier_port"
                    placeholder="{{ trans('server-listing::messages.placeholder.votifier_port') }}"
                    value="{{ old('votifier_port', $server->votifier_port ?? '') }}">
                @error('votifier_port')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label"
                    for="votifierPublicKey">{{ trans('server-listing::messages.fields.votifier_public_key') }}</label>
                <textarea name="votifier_public_key" id="votifierPublicKey"
                    class="form-control  @error('votifier_public_key') is-invalid @enderror"
                    placeholder="{{ trans('server-listing::messages.placeholder.votifier_public_key') }}">{{ old('votifier_public_key', $server->votifier_public_key ?? '') }}</textarea>
                @error('votifier_public_key')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header d-flex align-items-center">
        <i class="bi bi-gear me-2"></i>
        <strong>{{ trans('server-listing::messages.additional_settings') }}</strong>
    </div>
    <div class="card-body">
        <div class="row gx-3">
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" name="hide_voters" type="checkbox" value="1"
                        id="hideVoters">
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
                    <input class="form-check-input" name="hide_players_list" value="1" type="checkbox"
                        id="hidePlayer">
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
                    <input class="form-check-input" name="block_ping" value="1" type="checkbox"
                        id="blockPing">
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
                    <input class="form-check-input" name="block_version_detection" value="1" type="checkbox"
                        id="blockVersionDetection">
                    <label class="form-check-label" for="blockVersionDetection">
                        Block Version Detection
                    </label>

                </div>
                <div class="form-text">
                    <small><i class="bi bi-info-circle me-2"></i>Select this option if you want to force a version for
                        your server. This will disabled the automatic version detection.</small>
                </div>
            </div>
        </div>
    </div>
</div>


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
            const name = document.getElementById('nameInput').value;
            document.getElementById('slugInput').value = slugifyInput(name);
        }
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

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
    </style>
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
                            serverVersionValue.innerText = serverData.version;

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
