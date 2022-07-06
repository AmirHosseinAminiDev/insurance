<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $id
 *s @property mixed $insuranceType
 */
class InsuranceTypeRequest extends FormRequest
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
    public function rules(): array
    {
        if ($this->isMethod('PUT')) {
            return [
                'insurance_code' => 'required|numeric|min:1|max:999999|unique:insurance_types,insurance_code,'.$this->insuranceType->id,
                'name' => ['required', 'string', 'max:250', Rule::unique('insurance_types', 'name')->ignore($this->insuranceType->id)],
            ];
        }
        return [
            'name' => 'required|string|max:250|unique:insurance_types',
            'insurance_code' => 'required|numeric|min:1|max:999999|unique:insurance_types,insurance_code'
        ];
    }

    public function getName()
    {
        return $this->get('name');
    }

    public function getInsuranceCode()
    {
        return $this->get('insurance_code');
    }
}
