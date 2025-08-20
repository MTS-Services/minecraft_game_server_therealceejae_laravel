<div class="card shadow mb-4">
    <div class="card-header">
        {{ trans('server-listing::admin.vote.sites.list') }}
    </div>
    <div class="card-body">
        <ul>
            @php
                $domain = parse_url(route('home'), PHP_URL_HOST);
                $verifier = resolve(Azuriom\Plugin\ServerListing\Verification\VoteVerifier::class, ['siteDomain' => $domain]);
            @endphp

            @foreach ($verifier->getSites() as $site)
                <li>{{ $site }}</li>
            @endforeach
        </ul>
    </div>
</div>
