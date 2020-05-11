<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
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
            'nit' => 'required|integer|digits_between:6,9',
            'name_complete' => 'required|max:100',
            'email' => 'required|email|max:100',
            'direction' => 'required|max:150',
            'phone' => 'required|integer|digits:8',
            'observation' => 'nullable|max:150'
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
            'nit.required' => 'El NIT es obligatorio.',
            'nit.digits_between' => 'El número de NIT debe contener entre :min y :max dígitos.',
            'nit.integer' => 'El NIT debe de ser números enteros.',

            'name_complete.required'  => 'El nombre es obligatorio.',
            'name_complete.max'  => 'El nombre no debe tener más de :max caracteres.',

            'email.required'  => 'El correo electrónico es obligatorio.',
            'email.email'  => 'El correo electrónico no es válido.',
            'email.max'  => 'El correo electrónico no debe tener más de :max caracteres.',

            'direction.required'  => 'La dirección de domicilio es obligatorio.',
            'direction.max'  => 'La dirección de domicilio no debe tener más de :max caracteres.',

            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.digits' => 'El número de teléfono debe contener :digits dígitos.',
            'phone.integer' => 'El número de teléfono debe de ser números enteros.',

            'observation.max'  => 'La observación no debe tener más de :max caracteres.'
        ];
    }
}
