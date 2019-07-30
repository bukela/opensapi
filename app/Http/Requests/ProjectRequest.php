<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'organization_id'   => 'required',
            'donator_id'   => 'required',
            'project_value' => 'numeric|max:99999999|nullable',
            // 'description'   => 'required',
            
        ];
    }

    public function messages() {
        return [
            'title.required' => __('Title is required'),
            'organization_id.required' => __('Organization is required'),
            'donator_id.required' => __('Donator is required'),
            'project_value.max' => __('Maximum value is 99999999'),
            'project_value.numeric' => __('Please enter numeric value'),
            // 'description.required' => __('Description is required'),
        ];
    }
}
