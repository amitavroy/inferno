<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|min:2|max:100',
            'country' => 'max:50',
            'twitter' => 'max:60',
            'facebook' => 'max:60',
            'skype' => 'max:60',
            'linkedin' => 'max:60',
            'designation' => 'max:60',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'You need to mention your name.',
            'name.min' => 'You name should be at least 2 characters long.',
            'name.max' => 'We do not support names more than 100 characters.'
        ];
    }
}
