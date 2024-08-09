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
            'mail' => ['sometimes', 'email', 'confirmed', 'unique:users,mail,'.auth()->user()->id],
            'mail_current' => ['required_if:mail,!=,null', 'email', new MatchCurrentEmail],
            'motto' => ['sometimes', 'string', 'max:30'],
        ];
    }
}
