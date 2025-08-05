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
        'is_premium',
        'is_featured',
        'is_online',
        'is_approved',
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
        $imageRules = ['image', 'max:5000', 'mimes:jpg,jpeg,png,webp,gif'];

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
            'server_ip' => ['required', 'ip'],
            'server_port' => ['required', 'integer', 'min:1', 'max:65535'],
            'website_url' => ['required', 'url'],
            'discord_url' => ['nullable', 'url'],
            'banner_image' => array_merge($server ? ['nullable'] : ['required'], $imageRules),
            'logo_image' => array_merge($server ? ['nullable'] : ['required'], $imageRules),
            'version' => ['required', 'string', 'max:50'],
            'max_players' => ['required', 'integer', 'min:1'],
            'current_players' => ['nullable', 'integer', 'min:0'],
            'is_online' => ['nullable', 'boolean'],
            'is_premium' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'is_approved' => ['nullable', 'boolean'],
            'tags' => ['required', 'array'],
            'tags.*' => ['nullable', 'exists:server_listing_tags,id'],
            'vote_count' => ['nullable', 'integer', 'min:0'],
            'total_votes' => ['nullable', 'integer', 'min:0'],
            'last_ping' => ['nullable', 'date'],
            'position' => ['nullable', 'integer'],
            'youtube_video' => ['nullable', 'url'],
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
