<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
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
        if ($this->isMethod('PUT')) {
            return [
                'nombre'                    => 'required|string|max:191',
                'nit'                       => 'required|string|min:10|max:191',
                'email'                     => 'required|string|max:191|email',
                'numero_celular_empresa'    => 'required|integer|min:0|max:9999999999',
                'direccion'                 => 'required|string|max:191',
            ];
        } else {
            return [
                'nombre'                    => 'required|string|max:191',
                'nit'                       => 'required|string|min:10|max:191',
                'email'                     => 'required|string|max:191|email',
                'numero_celular_empresa'    => 'required|integer|min:0|max:9999999999',
                'direccion'                 => 'required|string|max:191',
            ];
        }
    }
}
