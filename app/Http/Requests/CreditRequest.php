<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditRequest extends FormRequest
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
            'discount_rate_id' => 'required|integer|exists:discount_rates,id'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'discount_rate_id.required' => 'El descuento es obligatorio.',
            'discount_rate_id.integer'  => 'El descuento debe de ser un número entero.',
            'discount_rate_id.exists'  => 'El descuento seleccionado no existe.',
        ];
    }
}
