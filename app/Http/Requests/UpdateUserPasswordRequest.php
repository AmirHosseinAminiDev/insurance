<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
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
            'password' => 'required|confirmed|min:6|max:20|different:current_password',
            'current_password' => 'required|current_password'
        ];
    }

    public function getPassword()
    {
        return $this->get('password');
    }

    public function getCurrentPassword()
    {
        return $this->get('current_password');
    }
}
