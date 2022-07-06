<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    private mixed $amount;

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
            'type' => 'required',
            'amount' => 'required|numeric',
        ];
       if ($this->file('attachment')){
           return array_merge($fields,[
               'attachment' => 'image|mimes:jpg,png,jpeg,svg|max:2048',
           ]);
       }
       return $fields;
    }
}
