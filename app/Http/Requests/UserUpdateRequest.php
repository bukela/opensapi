<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'active' => 'required|sometimes',
            'avatar' => 'image|max:3000',
            // 'email'      => 'required|email|unique:users,email,'.$this->user->id,
            'email'      => 'required|email',
            'password'   => 'nullable|string|confirmed|min:6',
            'description'   => 'sometimes'
        ];
    }

    public function messages() {
        return [
            'name.required' => __('Name Is Required'),
            'email.required' => __('Email Is Required'),
            'email.unique' => __('User with this email already exists'),
            'email.email' => __('Incorrect Email Format'),
            'avatar.max'=> __('Maximum upload image size is 3MB'),
            'avatar.image'=> __('File Must Be A Image'),
            
        ];
    }
}
