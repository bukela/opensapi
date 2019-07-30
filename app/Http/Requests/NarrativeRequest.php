<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NarrativeRequest extends FormRequest
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
            'project_value' => 'numeric|max:99999999',
        ];
    }

    public function messages() {

        return [
            'project_value.max' => __('Maximum value is 99.999.999'),
            'project_value.numeric' => __('Please enter numeric value'),

        ];
    }
}
