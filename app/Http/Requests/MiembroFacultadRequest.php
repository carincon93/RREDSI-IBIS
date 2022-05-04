<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MiembroFacultadRequest extends FormRequest
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
        if ($this->isMethod('PUT')) {
            return [
                'nombre'            => 'required|string|max:191',
                'email'             => 'required|string|max:191|email|unique:users,email,' . $this->route('user')->id . ',id',
                'tipo_documento'    => 'required|string| max:2',
                'numero_documento'  => 'required|integer|min:0|max:9999999999|unique:users,numero_documento,' . $this->route('user')->id . ',id',
                'numero_celular'    => 'required|integer|min:0|max:9999999999',
                'intereses'         => 'required|json',
                'esta_habilitado'   => 'required|boolean',
                'role_id.*'         => 'required|min:0|max:9999999999|exists:roles,id',
            ];
        } else {
            return [
                'nombre'            => 'required|string|max:191',
                'email'             => 'required|string|max:191|email|unique:users,email',
                'tipo_documento'    => 'required|string| max:2',
                'numero_documento'  => 'required|integer|min:0|max:9999999999|unique:users,numero_documento',
                'numero_celular'    => 'required|integer|min:0|max:9999999999',
                'intereses'         => 'required|json',
                'esta_habilitado'   => 'required|boolean',
                'role_id.*'         => 'required|min:0|max:9999999999|exists:roles,id',
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
        if ($this->intereses != null) {
            $this->merge([
                'intereses' => json_encode(explode(',', $this->intereses), true),
            ]);
        }
    }
}
