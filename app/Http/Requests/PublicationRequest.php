<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicationRequest extends FormRequest
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
            'title' => 'required|min:3|max:255',
            'description'  => 'required',
            'file' => 'mimes:pdf,docx,doc,png,jpg,jpeg,gif,pptx,ppt|max:5000|required',
            // 'active' => 'required|sometimes'
            // 'file' => 'max:5000|required',
            // 'file' => 'max:5000'
        ];
    }

    public function messages() {
        return [
            'title.required' => __('Title Is Required'),
            'description.required' => __('Description Is Required'),
            'file.max'=> __('Maximum upload file size is 5MB'),
            'file.mimes' => __('Unsupported File Type'),
            'file.required' => __('File Is Required')
        ];
    }
}
