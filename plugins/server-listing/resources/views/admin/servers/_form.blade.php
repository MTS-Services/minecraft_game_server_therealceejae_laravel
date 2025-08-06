@csrf

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
@endpush
@push('footer-scripts')
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.querySelector('#tagsInput');
            new Tagify(input);
        });
    </script> --}}
@endpush





<div class="row gx-3">
    <div class="col-md-4 mb-3">
        <label class="form-label" for="userSelect">{{ trans('server-listing::messages.fields.user') }}</label>
        <select class="form-select @error('user_id') is-invalid @enderror" id="userSelect" name="user_id">
            <option value="" hidden selected>{{ trans('server-listing::messages.fields.user-select') }}</option>
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
        <label class="form-label" for="countrySelect">{{ trans('server-listing::messages.fields.country') }}</label>
        <select class="form-select @error('country_id') is-invalid @enderror" id="countrySelect" name="country_id">
            <option value="" hidden selected>{{ trans('server-listing::messages.fields.country-select') }}
            </option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" @selected(old('country_id', $server->country_id ?? '') == $country->id)>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
        @error('country_id')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="nameInput">{{ trans('server-listing::messages.fields.name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name"
            value="{{ old('name', $server->name ?? '') }}"
            placeholder="{{ trans('server-listing::messages.placeholder.name') }}">

        @error('name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="slugInput">{{ trans('server-listing::messages.fields.slug') }}</label>
        <div class="input-group @error('slug') has-validation @enderror">
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slugInput" name="slug"
                value="{{ old('slug', $server->slug ?? '') }}">

            <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()">
                <i class="bi bi-arrow-clockwise"></i>
            </button>

            @error('slug')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="serverIpInput">{{ trans('server-listing::messages.fields.server_ip') }}</label>
        <input type="text" class="form-control @error('server_ip') is-invalid @enderror" id="serverIpInput"
            name="server_ip" placeholder="{{ trans('server-listing::messages.placeholder.server_ip') }}"
            value="{{ old('server_ip', $server->server_ip ?? '') }}">

        @error('server_ip')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label"
            for="serverPortInput">{{ trans('server-listing::messages.fields.server_port') }}</label>
        <input type="text" class="form-control @error('server_port') is-invalid @enderror" id="serverPortInput"
            name="server_port" placeholder="{{ trans('server-listing::messages.placeholder.server_port') }}"
            value="{{ old('server_port', $server->server_port ?? '') }}">

        @error('server_port')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="websiteUrlInput">{{ trans('server-listing::messages.fields.website_url') }}</label>
        <input type="url" class="form-control @error('website_url') is-invalid @enderror" id="websiteUrlInput"
            name="website_url" placeholder="{{ trans('server-listing::messages.placeholder.website_url') }}"
            value="{{ old('website_url', $server->website_url ?? '') }}">

        @error('website_url')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="discordUrlInput">{{ trans('server-listing::messages.fields.discord_url') }}</label>
        <input type="url" class="form-control @error('discord_url') is-invalid @enderror" id="discordUrlInput"
            name="discord_url" placeholder="{{ trans('server-listing::messages.placeholder.discord_url') }}"
            value="{{ old('discord_url', $server->discord_url ?? '') }}">

        @error('discord_url')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="versionInput">{{ trans('server-listing::messages.fields.version') }}</label>
        <input type="text" class="form-control @error('version') is-invalid @enderror" id="versionInput"
            name="version" placeholder="{{ trans('server-listing::messages.placeholder.version') }}"
            value="{{ old('version', $server->version ?? '') }}">

        @error('version')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="maxPlayersInput">{{ trans('server-listing::messages.fields.max_players') }}</label>
        <input type="number" class="form-control @error('max_players') is-invalid @enderror" id="maxPlayersInput"
            name="max_players" placeholder="{{ trans('server-listing::messages.placeholder.max_players') }}"
            value="{{ old('max_players', $server->max_players ?? '') }}">

        @error('max_players')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="tagsInput">{{ trans('server-listing::messages.fields.tags') }}</label>
        <select class="form-select @error('tags') is-invalid @enderror" id="tagsInput" name="tags[]" multiple>
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
                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
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



    <div class="col-md-4 mb-3">
        <label class="form-label"
            for="bannerImageInput">{{ trans('server-listing::messages.fields.banner_image') }}</label>
        <input type="file" class="form-control @error('banner_image') is-invalid @enderror" id="bannerImageInput"
            name="banner_image" accept="image/jpg,image/jpeg,image/png,image/gif"
            data-image-preview="bannerImagePreview">

        @error('banner_image')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror

        <img src="{{ isset($server->banner_image_url) ? $server->banner_image_url : '#' }}"
            class="mt-2 img-fluid rounded img-preview {{ isset($server->banner_image_url) ? '' : 'd-none' }}"
            alt="banner image" id="bannerImagePreview">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label"
            for="logoImageInput">{{ trans('server-listing::messages.fields.logo_image') }}</label>
        <input type="file" class="form-control @error('logo_image') is-invalid @enderror" id="logoImageInput"
            name="logo_image" accept="image/jpg,image/jpeg,image/png,image/gif"
            data-image-preview="logoImagePreview">

        @error('logo_image')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror

        <img src="{{ isset($server->logo_image_url) ? $server->logo_image_url : '#' }}"
            class="mt-2 img-fluid rounded img-preview {{ isset($server->logo_image_url) ? '' : 'd-none' }}"
            alt="banner image" id="logoImagePreview">
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
        <label for="youtubeVideoInput">{{ trans('server-listing::messages.fields.youtube_video') }}</label>
        <input type="url" class="form-control @error('youtube_video') is-invalid @enderror"
            id="youtubeVideoInput" name="youtube_video"
            placeholder="{{ trans('server-listing::messages.placeholder.youtube_video') }}"
            value="{{ old('youtube_video', $server->youtube_video ?? '') }}">

        @error('youtube_video')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>




    <div class="col mb-3">
        <label class="form-label" for="textArea">{{ trans('server-listing::messages.fields.description') }}</label>
        <textarea class="form-control html-editor @error('description') is-invalid @enderror" id="textArea"
            placeholder="{{ trans('server-listing::messages.placeholder.description') }}" name="description" rows="5">{{ old('description', $server->description ?? '') }}</textarea>

        @error('description')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
