@include('server-listing::admin.elements.select')

@include('admin.elements.editor')



@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>


    <script>
        // Snippet from @thierryc on GitHub

        // https://gist.github.com/codeguy/6684588?permalink_comment_id=3243980#gistcomment-3243980

        function slugifyInput(str) {

            return str

                .normalize(

                    'NFKD') // The normalize() using NFKD method returns the Unicode Normalization Form of a given string.

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
        .motdInput .tox.tox-tinymce {
            height: 250px !important;
        }
    </style>
@endpush

@push('footer-scripts')
    {{-- <script>

        document.addEventListener("DOMContentLoaded", function() {

            const input = document.querySelector('#tagsInput');

            new Tagify(input);

        });

    </script> --}}
@endpush

<div class="card mb-3">
    <div class="card-header d-flex align-items-center">
        <i class="bi bi-info-circle-fill me-2"></i>
        <strong>{{ trans('server-listing::messages.submission_card.server_info') }}</strong>
    </div>
    <div class="card-body">
        <div class="row gx-3">
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
                <label class="form-label"
                    for="javaServerIpInput">{{ trans('server-listing::messages.fields.java_server_ip') }} <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control @error('java_server_ip') is-invalid @enderror"
                    id="javaServerIpInput" name="java_server_ip" required
                    placeholder="{{ trans('server-listing::messages.placeholder.java_server_ip') }}"
                    value="{{ old('java_server_ip', $server->java_server_ip ?? '') }}">
                @error('java_server_ip')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label"
                    for="bedrockServerIp">{{ trans('server-listing::messages.fields.bedrock_server_ip') }}</label>
                <input type="text" class="form-control @error('bedrock_server_ip') is-invalid @enderror"
                    id="bedrockServerIp" name="bedrock_server_ip"
                    placeholder="{{ trans('server-listing::messages.placeholder.bedrock_server_ip') }}"
                    value="{{ old('bedrock_server_ip', $server->bedrock_server_ip ?? '') }}">
                @error('bedrock_server_ip')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="websiteUrlInput">{{ trans('server-listing::messages.fields.website_url') }} <span
                        class="text-danger">*</span></label>
                <input type="url" class="form-control @error('website_url') is-invalid @enderror"
                    id="websiteUrlInput" name="website_url" required
                    placeholder="{{ trans('server-listing::messages.placeholder.website_url') }}"
                    value="{{ old('website_url', $server->website_url ?? '') }}">
                @error('website_url')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="discordUrlInput">{{ trans('server-listing::messages.fields.discord_url') }}</label>
                <input type="url" class="form-control @error('discord_url') is-invalid @enderror"
                    id="discordUrlInput" name="discord_url"
                    placeholder="{{ trans('server-listing::messages.placeholder.discord_url') }}"
                    value="{{ old('discord_url', $server->discord_url ?? '') }}">
                @error('discord_url')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="minecraftVersionInput">{{ trans('server-listing::messages.fields.minecraft_version') }}
                    <span class="text-danger">*</span></label>
                <select name="minecraft_version" id="minecraftVersionInput" required
                    class="form-select @error('minecraft_version') is-invalid @enderror">
                    <option value="" hidden selected>
                        {{ trans('server-listing::messages.fields.minecraft_version_select') }}
                    </option>
                    <option value="1.1.2">
                        1.1.2
                    </option>
                </select>
                @error('minecraft_version')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="maxPlayersInput">{{ trans('server-listing::messages.fields.max_players') }}</label>
                <input type="number" class="form-control @error('max_players') is-invalid @enderror"
                    id="maxPlayersInput" name="max_players"
                    placeholder="{{ trans('server-listing::messages.placeholder.max_players') }}"
                    value="{{ old('max_players', $server->max_players ?? '') }}">
                @error('max_players')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="youtubeVideoInput">{{ trans('server-listing::messages.fields.youtube_video') }}</label>
                <input type="url" class="form-control @error('youtube_video') is-invalid @enderror"
                    id="youtubeVideoInput" name="youtube_video"
                    placeholder="{{ trans('server-listing::messages.placeholder.youtube_video') }}"
                    value="{{ old('youtube_video', $server->youtube_video ?? '') }}">
                @error('youtube_video')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="supportEmailInput">{{ trans('server-listing::messages.fields.support_email') }}</label>
                <input type="email" class="form-control @error('support_email') is-invalid @enderror"
                    id="supportEmailInput" name="support_email"
                    placeholder="{{ trans('server-listing::messages.placeholder.support_email') }}"
                    value="{{ old('support_email', $server->support_email ?? '') }}">
                @error('support_email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-12 mb-3 motdInput">
                <label class="form-label" for="motdInput">
                    {{ trans('server-listing::messages.fields.motd') }}
                </label>
                <textarea class="form-control html-editor @error('motd') is-invalid @enderror" id="motdInput"
                    placeholder="{{ trans('server-listing::messages.placeholder.motd') }}" name="motd" rows="2">{{ old('motd', $server->motd ?? '') }}</textarea>
                @error('motd')
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
                <label
                    for="discordServerIdInput">{{ trans('server-listing::messages.fields.discord_server_id') }}</label>
                <input type="url" class="form-control @error('discord_server_id') is-invalid @enderror"
                    id="discordServerIdInput" name="discord_server_id"
                    placeholder="{{ trans('server-listing::messages.placeholder.discord_server_id') }}"
                    value="{{ old('discord_server_id', $server->discord_server_id ?? '') }}">
                @error('discord_server_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>


            <div class="col-md-4 mb-3">
                <label for="tagsInput">{{ trans('server-listing::messages.fields.tags') }} <span
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
                <label
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

            <div class="col-md-6 mb-3">
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
            <div class="col-md-6 mb-3">
                <label class="form-label"
                    for="logoImageInput">{{ trans('server-listing::messages.fields.logo_image') }} <span
                        class="text-danger">*</span></label>
                <input type="file" class="form-control @error('logo_image') is-invalid @enderror" required
                    id="logoImageInput" name="logo_image" accept="image/jpg,image/jpeg,image/png,image/gif"
                    data-image-preview="logoImagePreview">
                @error('logo_image')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
                <img src="{{ isset($server->logo_image_url) ? $server->logo_image_url : '#' }}"
                    class="mt-2 img-fluid rounded img-preview {{ isset($server->logo_image_url) ? '' : 'd-none' }}"
                    alt="banner image" id="logoImagePreview">
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
                <label for="votifierHost">{{ trans('server-listing::messages.fields.votifier_host') }}</label>
                <input type="url" class="form-control @error('votifier_host') is-invalid @enderror"
                    id="votifierHost" name="votifier_host"
                    placeholder="{{ trans('server-listing::messages.placeholder.votifier_host') }}"
                    value="{{ old('votifier_host', $server->votifier_host ?? '') }}">
                @error('votifier_host')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="votifierPortInput">{{ trans('server-listing::messages.fields.votifier_port') }}</label>
                <input type="number" class="form-control @error('votifier_port') is-invalid @enderror"
                    id="votifierPortInput" name="votifier_port"
                    placeholder="{{ trans('server-listing::messages.placeholder.votifier_port') }}"
                    value="{{ old('votifier_port', $server->votifier_port ?? '') }}">
                @error('votifier_port')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="col-md-12 mb-3">
                <label
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
