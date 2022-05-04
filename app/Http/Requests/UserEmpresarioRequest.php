<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEmpresarioRequest extends FormRequest
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
                'email'                             => 'required|string|max:191|email|unique:users,email,' . $this->route('user')->id . ',id',
                'password'                          => 'nullable|string|min:6|different:old_password|confirmed',
                'tipo_documento'                    => 'required|string| max:2',
                'numero_documento'                  => 'required|integer|min:0|max:9223372036854775807|unique:users,numero_documento,' . $this->route('user')->id . ',id',
                'numero_celular'                    => 'required|integer|min:0|max:9223372036854775807',
                'nit'                               => 'required|string|max:255',
                'nombre_empresa'                    => 'required|string|max:255',
                'direccion_empresa'                 => 'required|string|max:255',
                'numero_celular_empresa'            => 'required|string|max:255',
                'email_empresa'                     => 'required|string|max:255',
                'esta_habilitado'                   => 'required|boolean',
                'autorizacion_tratamiento_datos'    => 'required|boolean',
            ];
        } else {
            return [
                'name'                              => 'required|string|max:191',
                'email'                             => 'required|string|max:191|email|unique:users,email',
                'password'                          => 'required|string|min:6|different:old_password|confirmed',
                'tipo_documento'                    => 'required|string| max:2',
                'numero_documento'                  => 'required|integer|min:0|max:9223372036854775807|unique:users,numero_documento',
                'numero_celular'                    => 'required|integer|min:0|max:9223372036854775807',
                'nit'                               => 'required|string|max:255',
                'nombre_empresa'                    => 'required|string|max:255',
                'direccion_empresa'                 => 'required|string|max:255',
                'numero_celular_empresa'            => 'required|string|max:255',
                'email_empresa'                     => 'required|string|max:255',
                'esta_habilitado'                   => 'required|boolean',
                'autorizacion_tratamiento_datos'    => 'required|boolean',
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
        if (is_array($this->esta_habilitado)) {
            $this->merge([
                'esta_habilitado' => $this->esta_habilitado['value'] == '1' ? 1 : 0,
            ]);
        }

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
