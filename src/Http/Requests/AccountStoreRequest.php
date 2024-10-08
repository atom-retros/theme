<?php

namespace Atom\Theme\Http\Requests;

use Atom\Theme\Rules\MatchCurrentEmail;
use Illuminate\Foundation\Http\FormRequest;

class AccountStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mail_current' => ['sometimes', 'nullable', 'email', new MatchCurrentEmail],
            'mail' => ['sometimes', 'nullable', 'email', 'confirmed', 'unique:users,mail,'.auth()->user()->id],
            'motto' => ['sometimes', 'nullable', 'string', 'max:30'],
        ];
    }
}
