<?php

namespace Azuriom\Plugin\ServerListing\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ServerRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The attributes represented by checkboxes.
     *
     * @var array<int, string>
     */
    protected array $checkboxes = [
        'is_online',
        'is_premium',
        'is_featured',
        'is_approved',
        'hide_voters',
        'hide_players_list',
        'block_ping',
        'block_version_detection',
        'terms_accepted',
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust if you want to restrict who can submit
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $server = $this->route('server'); // route binding for update
        $logoRules =  ['image', 'dimensions:width=60,height=60', 'max:5000', 'mimes:jpg,jpeg,png,webp,gif'];
        $bannerRules =  ['image', 'dimensions:width=468,height=60', 'max:5000', 'mimes:jpg,jpeg,png,webp,gif'];
        return [
            'user_id' => 'required|sometimes|exists:users,id',
            'country_id' => ['required', 'exists:server_listing_countries,id'],
            'name' => ['required', 'string', 'max:100'],
            'slug' => [
                'required',
                'string',
                'max:100',
                new Slug,
                Rule::unique('server_listing_servers', 'slug')->ignore($server, 'slug'),
            ],
            'description' => ['required', 'string'],
            'motd' => ['nullable', 'string', 'max:150'],
            'java_server_ip' => ['required'],
            'bedrock_server_ip' => ['nullable'],
            'website_url' => ['required', 'url'],
            'discord_url' => ['nullable', 'url'],
            'discord_server_id' => ['nullable'],
            'banner_image' =>  array_merge($server ? ['nullable'] : ['required'], $bannerRules),
            'logo_image' => array_merge($server ? ['nullable'] : ['required'], $logoRules),
            'minecraft_version' => ['required', 'string', 'max:50'],
            'support_email' => ['nullable', 'email'],
            'votifier_host' => ['nullable'],
            'votifier_port' => ['nullable', 'integer'],
            'votifier_public_key' => ['nullable'],
            'teamspeak_server_api_key' => ['nullable'],
            'max_players' => ['nullable', 'integer', 'min:1'],
            'current_players' => ['nullable', 'integer', 'min:0'],
            'is_online' => ['nullable', 'boolean'],
            'is_premium' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'is_approved' => ['nullable', 'boolean'],
            'hide_voters' => ['nullable', 'boolean'],
            'hide_players_list' => ['nullable', 'boolean'],
            'block_ping' => ['nullable', 'boolean'],
            'block_version_detection' => ['nullable', 'boolean'],
            'terms_accepted' => ['sometimes', 'required', 'boolean'],
            'youtube_video' => ['nullable', 'url'],
            'position' => ['nullable', 'integer'],
            'tags' => ['required', 'array'],
            'tags.*' => ['nullable', 'integer', 'exists:server_listing_tags,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            if ($this->boolean('is_featured')) {
                $serverSlug = optional($this->route('server'))->id;

                $featuredCount = ServerListing::where('is_featured', true)
                    ->count();
                // ->when($serverSlug, fn($q) => $q->where('slug', '!=', $serverSlug))

                if ($featuredCount >= 10) {
                    $validator->errors()->add('is_featured_limit', trans('Only a maximum of 10 servers can be featured at a time.'));
                }
            }
        });
    }
}
