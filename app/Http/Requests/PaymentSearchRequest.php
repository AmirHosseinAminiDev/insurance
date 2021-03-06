<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSearchRequest extends FormRequest
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
            'sortFilter' => 'nullable|in:pendding,unpaid,paid,all',
            'startDate' => 'nullable|date_format:Y/m/d',
            'endDate' => 'nullable|date_format:Y/m/d',
        ];
    }
}
