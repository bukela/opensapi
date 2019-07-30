<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required',
            'approved_for_category' => 'nullable|numeric',
            'approved_for_category_private' => 'nullable|numeric',
            'direct_cost' => 'required|sometimes'
        ];
    }

    public function messages() {

        return [
            'name.required' => __('Category name is required'),
            'approved_for_category.numeric' => __('Please Enter Numeric Value'),
            'approved_for_category_private.numeric' => __('Please Enter Numeric Value')
        ];

    }
}
