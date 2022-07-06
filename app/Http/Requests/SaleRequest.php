<?php

namespace App\Http\Requests;

use App\Constants\SaleType;
use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
        $installment_type = SaleType::INSTALLMENT;
        return [
            'customer_id' => 'required',
            'insurance_type_id' => 'required',
            'price' => 'required|numeric|min:1000|max:99999999',
            'pay_type' => 'required',
            'count' => "required_if:pay_type,{$installment_type}",
        ];
    }
}
