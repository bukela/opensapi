<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
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
    public function rules(Request $request)
    {
        // $user = $this->route('user');
        // dd($user);
        if($request->has('user')) {

            return [
                'name' => 'required',
                'active' => 'required|sometimes',
                'avatar' => 'sometimes|image|max:3000',
                'donator' => 'required_without:organization',
                'organization' => 'required_without:donator',
                'moderator' => 'required|sometimes',
                // 'email'      => 'required|email|unique:users,email,' . $this->get('id'),
                'email'      => 'required|email|unique:users,email',
                'password'   => 'required|confirmed|min:6',
                'description'   => 'sometimes'
            ];            

        } else {

            return [
                'name' => 'required',
                'active' => 'required|sometimes',
                'avatar' => 'image|max:3000',
                // 'donator' => 'required_without:organization',
                // 'organization' => 'required_without:donator',
                'moderator' => 'required|sometimes',
                // 'email'      => 'required|email|unique:users,email,' . $this->get('id'),
                'email'      => 'required|email|unique:users,email',
                'password'   => 'required|confirmed|min:6',
                'description'   => 'sometimes'
            ];

        }
        
    }

    public function messages() {
        return [
            'name.required' => __('Name Is Required'),
            'email.required' => __('Email Is Required'),
            'email.unique' => __('User with this email already exists'),
            'email.email' => __('Incorrect Email Format'),
            'avatar.max'=> __('Maximum upload image size is 3MB'),
            'avatar.image'=> __('File Must Be A Image'),
            'password.min' => __('Password Must Be At Least 6 Characters')
            // 'donator.required_without' => __('Choose Donator'),
            // // 'organization.required_without' => __('The organization field is required when donator is not present')
            // 'organization.required_without' => __('Choose Organization')
        ];
    }
}
