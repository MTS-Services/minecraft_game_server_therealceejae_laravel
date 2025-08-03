<?php

namespace Azuriom\Plugin\ServerListing\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Azuriom\Rules\Slug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $imageRules = ['image', 'max:5000', 'mimetypes:image/jpeg,image/png,image/webp,image/gif'];

        return [
            'user_id' => 'required|sometimes|exists:users,id',
            'category_id' => ['required', 'exists:server_listing_categories,id'],
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
            'is_online' => ['boolean'],
            'is_premium' => ['boolean'],
            'is_featured' => ['boolean'],
            'is_approved' => ['boolean'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'vote_count' => ['nullable', 'integer', 'min:0'],
            'total_votes' => ['nullable', 'integer', 'min:0'],
            'last_ping' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
