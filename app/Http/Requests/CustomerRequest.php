<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        $fields = [
            'first_name' => 'required|string|max:250',
            'last_name' => 'required|string|max:250',
        ];
        if ($this->isMethod('PUT')) {
            return array_merge($fields,
                [
                    'mobile' => ['required', 'ir_mobile', Rule::unique('customers', 'mobile')->ignore($this->customer->id)],
                    'national_code' => ['required','ir_national_code',Rule::unique('customers','national_code')->ignore($this->customer->id)],
                ]);
        }
        return array_merge($fields,
            [
                'mobile' => 'required|unique:customers|ir_mobile',
                'national_code' => 'required|unique:customers|ir_national_code',
            ]);

    }

    public function getFirstName()
    {
        return $this->get('first_name');
    }

    public function getLastName()
    {
        return $this->get('last_name');
    }

    public function getNationalCode()
    {
        return $this->get('national_code');
    }

    public function getMobile()
    {
        return $this->get('mobile');
    }
}
