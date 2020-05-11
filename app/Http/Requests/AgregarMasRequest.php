<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgregarMasRequest extends FormRequest
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
            'quantity' => 'required|integer|between:1,100',
            'product_id' => 'required|integer|exists:products,id'
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
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.integer'  => 'La cantidad debe de ser un número entero.',
            'quantity.between'  => 'La cantidad debe ser un valor entre :min y :max.',

            'product_id.required' => 'El producto es obligatorio.',
            'product_id.integer'  => 'El producto debe de ser un número entero.',
            'product_id.exists'  => 'El producto seleccionado no existe.'
        ];
    }
}
