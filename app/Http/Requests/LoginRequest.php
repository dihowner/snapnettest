<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\AuthorizeRequest;

class LoginRequest extends AuthorizeRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255']
        ];
    }
    
    public function messages() : array
    {
        return [
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
            'email.string' => 'The email field should be a string.',
            'password.string' => 'The password field should be a string.',
            'email.unique' => 'The email already exist, please use a new email'
        ];
    }
}