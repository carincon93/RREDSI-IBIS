<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerfilRequest extends FormRequest
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
                'name'                              => 'required|string|max:191',
                'email'                             => 'required|string|max:191|email|unique:users,email,' . auth()->user()->id . ',id',
                'password'                          => 'nullable|string|min:6|different:old_password|confirmed',
                'tipo_documento'                    => 'required|string| max:2',
                'numero_documento'                  => 'required|integer|min:0|max:9223372036854775807|unique:users,numero_documento,' . auth()->user()->id . ',id',
                'numero_celular'                    => 'required|integer|min:0|max:9223372036854775807',
                'perfil'                            => 'nullable|string',
                'intereses'                         => 'nullable|json',
                'autorizacion_tratamiento_datos'    => 'required|boolean',
                'cv'                                => 'nullable|mimetypes:application/pdf|max:10000000',
            ];
        }
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (is_array($this->autorizacion_tratamiento_datos)) {
            $this->merge([
                'autorizacion_tratamiento_datos' => $this->autorizacion_tratamiento_datos['value'] == '1' ? 1 : 0,
            ]);
        }

        if (is_array($this->tipo_documento)) {
            $this->merge([
                'tipo_documento' => $this->tipo_documento['value'],
            ]);
        }
    }
}
