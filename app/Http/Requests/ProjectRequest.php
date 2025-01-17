<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Enums\ProjectStatusEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\AuthorizeRequest;

class ProjectRequest extends AuthorizeRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $api_route = Route::currentRouteName();
        
        if ($api_route == "project.update") {
            $id = $this->route('id');
            return [
                'name' => ['required', 'string', 'max:255', Rule::unique('projects', 'name')->ignore($id)],
                'description' => ['required', 'string', 'max:255'],
                'start_date' => ['required', 'string', 'date'],
                'end_date' => ['required', 'string', 'date', 'after_or_equal:start_date'],
                'description' => ['required', 'string', 'max:255'],
                'status' => ['required', Rule::enum(ProjectStatusEnum::class)],
            ];
        } else {
            return [
                'name' => ['required', 'string', 'max:255', Rule::unique('projects', 'name')],
                'description' => ['required', 'string', 'max:255'],
                'status' => ['required', Rule::enum(ProjectStatusEnum::class)],
            ];
        }
        
    }
    
    public function messages() : array
    {
        return [
            'name.required' => 'The project name field is required.',
            'description.required' => 'The project description field is required.',
            'status.required' => 'The project status field is required.',
            'start_date.required' => 'The start date is required.',
            'end_date.required' => 'The end date is required.',
            'name.string' => 'The project name field should be a string.',
            'description.string' => 'The project description field should be a string.',
            'name.string' => 'The project name field should be a string.',
            'name.unique' => 'The project name already exist, please use a new project name',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
        ];
    }
}