@csrf
@include('server-listing::admin.elements.select')
<div class="row gx-3">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="nameInput">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name"
            value="{{ old('name', $site->name ?? '') }}" placeholder="My Awesome Site" required>

        @error('name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="rewardSelect">Rewards</label>

        <select class="form-select @error('rewards') is-invalid @enderror" id="rewardSelect" name="rewards[]" multiple
            required>
            @foreach ($rewards as $reward)
                <option value="{{ $reward->id }}" @selected(isset($site) && $site->rewards->contains($reward))>{{ $reward->name }}</option>
            @endforeach
        </select>

        @empty($rewards)
            <a href="{{ route('server-listing.admin.vote.rewards.create') }}" class="btn btn-success btn-sm" target="_blank"
                rel="noopener noreferrer">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
        @endempty

        @error('rewards')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="urlInput">URL</label>
    <input type="url" class="form-control @error('url') is-invalid @enderror" id="urlInput" name="url"
        value="{{ old('url', $site->url ?? '') }}" placeholder="https://minecraft-server.com/vote/{player}" required>

    @error('url')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror

    <div class="form-text">The {player} and {ip} variables are available.</div>
    <div id="verificationStatusLabel" class="form-text text-info d-none"></div>
</div>

<div class="d-none" id="verificationGroup">
    <div class="mb-3 form-check form-switch">
        <input type="checkbox" class="form-check-input" id="verificationSwitch" name="has_verification"
            @checked(old('has_verification', $site->has_verification ?? true))>
        <label class="form-check-label"
            for="verificationSwitch">Enable vote verification</label>
    </div>

    <div class="mb-3 d-none" id="keyGroup">
        <label id="keyLabel"
            for="keyInput">Verification Key</label>
        <input type="text" class="form-control @error('verification_key') is-invalid @enderror" id="keyInput"
            name="verification_key" value="{{ old('verification_key', $site->verification_key ?? '') }}" placeholder="Optional verification key">

        @error('verification_key')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="row gx-3">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="intervalInput">Vote Delay</label>
        <div class="input-group @error('vote_delay') has-validation @enderror">
            <input type="number" min="0" class="form-control @error('vote_delay') is-invalid @enderror"
                id="intervalInput" name="vote_delay" value="{{ old('vote_delay', $site->vote_delay ?? '1440') }}"
                required>
            <span class="input-group-text">minutes</span>
            @error('vote_delay')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="enableSwitch" name="is_enabled" @checked(old('is_enabled', $site->is_enabled ?? true))>
    <label class="form-check-label" for="enableSwitch">Enable this site</label>
</div>

@push('footer-scripts')
    <script>
        const urlInput = document.getElementById('urlInput');
        const verificationStatusLabel = document.getElementById('verificationStatusLabel');
        const verificationGroup = document.getElementById('verificationGroup');
        const verificationKeyGroup = document.getElementById('keyGroup');
        const verificationKeyLabel = document.getElementById('keyLabel');

        function updateVoteVerification() {
            if (urlInput.value === '') {
                verificationGroup.classList.add('d-none');
                verificationStatusLabel.classList.add('d-none');
                return;
            }

            axios.get('{{ route('server-listing.admin.vote.sites.verification') }}', {
                    params: {
                        url: urlInput.value
                    }
                })
                .then(function(response) {
                    verificationStatusLabel.innerText = response.data.info;
                    verificationStatusLabel.classList.remove('d-none');

                    if (!response.data.supported) {
                        verificationGroup.classList.add('d-none');
                        return;
                    }

                    if (response.data.automatic) {
                        verificationKeyGroup.classList.add('d-none');
                        verificationGroup.classList.remove('d-none');
                        return;
                    }

                    verificationKeyLabel.innerText = response.data.label;
                    verificationKeyGroup.classList.remove('d-none');
                    verificationGroup.classList.remove('d-none');
                }).catch(function() {
                    verificationGroup.classList.add('d-none');
                    verificationStatusLabel.classList.add('d-none');
                });
        }

        urlInput.addEventListener('focusout', updateVoteVerification);

        document.addEventListener('DOMContentLoaded', updateVoteVerification);
    </script>
@endpush
