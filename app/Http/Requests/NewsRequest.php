<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'body'  => 'required',
            'flyers.*' => 'image|max:3000',
            // 'flyers.*' => 'image',
            'featured' => 'sometimes|image|max:3000',
            'active' => 'required|sometimes'
        ];
    }

    public function messages() {
        return [
            'title.required' => __('Title Is Required'),
            'body.required' => __('Body Is Required'),
            'flyers.*'.'max'=> __('Maximum upload image size is 3MB'),
            'flyers.*'.'image'=> __('File Must Be A Image'),
            'featured.max' => __('Maximum upload image size is 3MB'),
        ];
    }
}
