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
<div class="row gx-3">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="nameInput">{{ trans('server-listing::messages.fields.name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name"
            value="{{ old('name', $tag->name ?? '') }}"
            placeholder="{{ trans('server-listing::messages.placeholder.name') }}">

        @error('name')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="slugInput">{{ trans('server-listing::messages.fields.slug') }}</label>
        <div class="input-group @error('slug') has-validation @enderror">
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slugInput" name="slug"
                value="{{ old('slug', $tag->slug ?? '') }}">

            <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()">
                <i class="bi bi-arrow-clockwise"></i>
            </button>

            @error('slug')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-3">
        <label class="form-label" for="isActiveSwitch">{{ trans('server-listing::messages.fields.status') }}</label>
        <div class="mb-3 form-check form-switch">
            <input type="checkbox" class="form-check-input" id="isActiveSwitch" name="is_active"
                @checked(old('is_active', $tag->is_active ?? false))>
            <label class="form-check-label"
                for="isActiveSwitch">{{ trans('server-listing::messages.fields.is_active') }}</label>
        </div>
    </div>



</div>
