<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'empresa_id'             => 'required',
            'proyecto_id'            => 'required',
            'activo'                 => 'required',
        ];
    }
}
