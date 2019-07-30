<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required|max:255',
            'content' => 'required',
            'flyers.*' => 'image|max:3000',
            // 'flyers.*' => 'image',
            'featured' => 'sometimes|image|max:3000',
            'active' => 'required|sometimes'
        ];
    }

    public function messages() {
        return [
            'title.required' => __('Title is required'),
            'content.required' => __('Event content is required'),
            'flyers.*'.'max'=> __('Maximum upload image size is 3MB'),
            'flyers.*'.'image'=> __('File Must Be A Image'),
            'featured.max' => __('Maximum upload image size is 3MB'),
            'featured.image' => __('File Must Be A Image')
            
        ];
    }
}
