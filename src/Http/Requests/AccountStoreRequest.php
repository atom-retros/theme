<?php

namespace Atom\Theme\Http\Requests;

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
            'mail' => ['required', 'email', 'unique:users,mail,' . auth()->user()->id],
            'motto' => ['required', 'string', 'max:30'],
        ];
    }
}
