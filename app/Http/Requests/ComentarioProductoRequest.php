<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComentarioProductoRequest extends FormRequest
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
            'comment' => 'required|max:200',
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
            'comment.required' => 'El comentario es obligatorio.',
            'comment.max'  => 'El comentario no debe tener más de :max caracteres.',
            'product_id.required' => 'El producto es obligatorio.',
            'product_id.integer'  => 'El producto debe de ser un número entero.',
            'product_id.exists'  => 'El producto seleccionado no existe.',
        ];
    }
}
