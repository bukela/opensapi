<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CostRequest extends FormRequest
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
            'category_id' => 'required',
            'project_id' => 'required',
            'description'  => 'required',
            // 'spent' => 'required|numeric',
            'spent_donator' => 'required|sometimes|numeric',
            'spent_private' => 'required|sometimes|numeric',
            'approved' => 'required|sometimes',
            // 'file' => 'sometimes|image'
            'file' => 'mimes:pdf,docx,pptx,ppt,doc,png,jpg,jpeg,gif|max:6000'
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => __('Please select category'),
            'project_id.required' => __('Please select project'),
            // 'spent.required' => __('Spent is required'),
            'spent_donator.numeric' => __('Please Enter Numeric Value'),
            'spent_private.numeric' => __('Please Enter Numeric Value'),
            'description.required' => __('Description is required'),
            'file.mime' => __('Unsupported File Type'),
            'file.max' => __('Maximum upload file size is 6MB')
        ];


    }
}
