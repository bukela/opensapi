<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
            'description' => 'required',
            'slides.*' => 'image|max:3000',
        ];
    }

    public function messages()
    {
        return [

            'title.required' => __('Title Is Required'),
            'description.required' => __('Description Is Required')

        ];
    }
}
