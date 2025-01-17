<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\AuthorizeRequest;

class EmployeeReqeust extends AuthorizeRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $api_route = Route::currentRouteName();
        
        if ($api_route == "employee.update") {
            $id = $this->route('id');
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'email', Rule::unique('employees', 'email')->ignore($id)],
                'position' => ['required', 'string', 'max:255'],
                'project_id' => ['required', 'string', 'max:255'], 'exists:projects,id',
            ];
        } else {
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'email', Rule::unique('employees', 'email')],
                'position' => ['required', 'string', 'max:255'],
                'project_id' => ['required', 'string', 'max:255'], 'exists:projects,id',
            ];
        }
    }
    
    public function messages() : array
    {
        return [
            'name.required' => 'The project name field is required.',
            'description.required' => 'The project description field is required.',
            'status.required' => 'The project status field is required.',
            'name.string' => 'The project name field should be a string.',
            'description.string' => 'The project description field should be a string.',
            'name.string' => 'The project name field should be a string.',
        ];
    }
}