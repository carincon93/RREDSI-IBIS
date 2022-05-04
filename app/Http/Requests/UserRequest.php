<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                'perfil'                            => 'nullable|string',
                'intereses'                         => 'nullable|json',
                'esta_habilitado'                   => 'required|boolean',
                'autorizacion_tratamiento_datos'    => 'required|boolean',
                'cv'                                => 'nullable|mimetypes:application/pdf|max:10000000',
                'institucion_educativa_id'          => 'required_if:tipo_usuario,rredsi|nullable|min:0|max:9223372036854775807|exists:instituciones_educativas,id',
                'role_id.*'                         => 'required|min:0|max:9223372036854775807|exists:roles,id',
            ];
        } else {
            return [
                'name'                              => 'required|string|max:191',
                'email'                             => 'required|string|max:191|email|unique:users,email',
                'password'                          => 'required|string|min:6|different:old_password|confirmed',
                'tipo_documento'                    => 'required|string| max:2',
                'numero_documento'                  => 'required|integer|min:0|max:9223372036854775807|unique:users,numero_documento',
                'numero_celular'                    => 'required|integer|min:0|max:9223372036854775807',
                'intereses'                         => 'nullable|json',
                'perfil'                            => 'nullable|string',
                'autorizacion_tratamiento_datos'    => 'required|boolean',
                'cv'                                => 'nullable|mimetypes:application/pdf|max:10000000',
                'institucion_educativa_id'          => 'required_if:tipo_usuario,rredsi|nullable|min:0|max:9223372036854775807|exists:instituciones_educativas,id',
                'role_id.*'                         => 'required|min:0|max:9223372036854775807|exists:roles,id',
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

        if (is_array($this->institucion_educativa_id)) {
            $this->merge([
                'institucion_educativa_id' => $this->institucion_educativa_id['value'],
            ]);
        }

        if (is_array($this->tipo_documento)) {
            $this->merge([
                'tipo_documento' => $this->tipo_documento['value'],
            ]);
        }
    }
}
