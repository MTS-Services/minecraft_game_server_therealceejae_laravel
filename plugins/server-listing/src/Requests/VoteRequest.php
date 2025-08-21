<?php

namespace Azuriom\Plugin\ServerListing\Requests;

use Azuriom\Plugin\ServerListing\Rule\UniqueVoteRule;
use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $config = config('voting.validation.username_validation');

        return [
            'username' => [
                'required',
                'string',
                "min:{$config['min_length']}",
                "max:{$config['max_length']}",
                "regex:{$config['pattern']}",
                new UniqueVoteRule($this->route('server'))
            ],
            'captcha' => config('voting.validation.captcha_enabled') ? ['required', 'captcha'] : [],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Please enter your Minecraft username.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'username.min' => 'Username must be at least :min characters long.',
            'username.max' => 'Username cannot exceed :max characters.',
            'captcha.required' => 'Please complete the captcha verification.',
            'captcha.captcha' => 'Captcha verification failed. Please try again.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'username' => trim($this->username),
            'ip_address' => $this->ip(),
        ]);
    }
}
