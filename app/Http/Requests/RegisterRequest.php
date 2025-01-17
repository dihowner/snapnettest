<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\AuthorizeRequest;

class RegisterRequest extends AuthorizeRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'max:255']
        ];
    }
    
    public function messages() : array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
            'name.string' => 'The name field should be a string.',
            'email.string' => 'The email field should be a string.',
            'password.string' => 'The password field should be a string.',
            'email.unique' => 'The email already exist, please use a new email'
        ];
    }
}