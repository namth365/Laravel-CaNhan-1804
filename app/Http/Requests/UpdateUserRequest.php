<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        if (isset($this->changePassword)) {
            return [
                'name' => ['required', 'min:3'],
                'password' => ['required', 'min:6'],
                'password_confirmation' => ['required', 'min:6', 'same:password'],
            ];
        } else {
            return [
                'name' => ['required'],
            ];
        }
    }
    public function messages()
    {
        return [
            'password.required' => 'Password can not be blank !',
            'name.required'     => 'First and last name cannot be left blank !',
            'name.min'          => 'Your name is too short !',
            'password.min'      => 'Password must not be less than 6 characters !'
        ];
    }
}
