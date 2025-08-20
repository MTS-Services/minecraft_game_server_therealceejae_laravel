@csrf
@include('server-listing::admin.elements.select')

<div class="row gx-3">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="nameInput">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name"
            value="{{ old('name', $reward->name ?? '') }}" placeholder="My Awesome Reward" required>
        @error('name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="chancesInput">Chances</label>
        <div class="input-group @error('chances') has-validation @enderror">
            <input type="number" min="0" max="100" step="0.01"
                class="form-control @error('chances') is-invalid @enderror" id="chancesInput" name="chances"
                value="{{ old('chances', $reward->chances ?? '0') }}" required>
            <div class="input-group-text">%</div>
            @error('chances')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="moneyInput">Money</label>
        <div class="input-group @error('money') has-validation @enderror">
            <input type="number" min="0" step="0.01" max="999999"
                class="form-control @error('money') is-invalid @enderror" id="moneyInput" name="money"
                value="{{ old('money', $reward->money ?? '') }}">
            <div class="input-group-text">{{ money_name() }}</div>
            @error('money')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="serversSelect">Servers</label>
        <select class="form-select @error('servers') is-invalid @enderror" id="serversSelect" name="servers[]" multiple>
            @foreach ($servers as $server)
                <option value="{{ $server->id }}" @selected(isset($reward) && $reward->servers->contains($server->id))>{{ $server->name }}</option>
            @endforeach
        </select>
        @error('servers')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="row">


    {{-- <div class="mb-3 col-md-6">
        <label class="form-label" for="imageInput">{{ trans('server-listing::messages.fields.image') }}</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" id="imageInput" name="image"
            accept=".jpg,.jpeg,.jpe,.png,.gif,.bmp,.svg,.webp" data-image-preview="imagePreview">
        @error('image')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <img src="{{ $reward->image ?? false ? $reward->imageUrl() : '#' }}"
            class="mt-2 img-fluid rounded img-preview {{ $reward->image ?? false ? '' : 'd-none' }}" alt="Image"
            id="imagePreview">
    </div> --}}
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="needOnlineSwitch" name="need_online"
        @checked(old('need_online', $reward->need_online ?? true))>
    <label class="form-check-label"
        for="needOnlineSwitch">Require player to be online</label>
</div>

<div class="mb-3">
    <label class="form-label">Commands</label>
    @include('admin.elements.list-input', [
        'name' => 'commands',
        'values' => $reward->commands ?? [],
        'placeholder' => 'ex: /give {player} stone 1',
    ])
    <div class="form-text">The {player} and {ip} variables are available.</div>
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="enableSwitch" name="is_enabled" @checked(old('is_enabled', $reward->is_enabled ?? true))>
    <label class="form-check-label" for="enableSwitch">Enable this reward</label>
</div>
