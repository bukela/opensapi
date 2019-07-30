<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'email' => 'required|email',
            'message' => 'required'

        ];
    }

    public function messages()
    {
        return [

            'name.required' => __('Name Is Required'),
            'email.required' => __('Email Is Required'),
            'email.email' => __('Incorrect Email Format'),
            'message.required' => __('Message Is Required'),

        ];
    }
}
