<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:16',
            'cpassword' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email address is already used.',
            'cpassword.required' => 'You need to confirm your password.',
            'cpassword.same' => 'This should match your password field.'
        ];
    }
}
