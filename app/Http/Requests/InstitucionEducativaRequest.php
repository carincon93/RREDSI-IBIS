<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstitucionEducativaRequest extends FormRequest
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
                'logo'              => 'nullable|mimes:jpeg,png,bmp,tiff |max:4000000',
                'nombre'            => 'required|string|max:191',
                'nit'               => 'required|string|max:191|unique:instituciones_educativas,nit,' . $this->route('institucion_educativa')->id . ',id',
                'direccion'         => 'required|string|max:191',
                'ciudad'            => 'required|string|max:191',
                'numero_telefono'   => 'required|string|max:191',
                'sitio_web'         => 'required|url|max:191',
                'nodo_id'           => 'required|integer|min:0|max:9223372036854775807|exists:nodos,id',
            ];
        } else {
            return [
                'logo'              => 'required|mimes:jpeg,png,bmp,tiff |max:4000000',
                'nombre'            => 'required|string|max:191',
                'nit'               => 'required|max:191|unique:instituciones_educativas,nit',
                'direccion'         => 'required|string|max:191',
                'ciudad'            => 'required|string|max:191',
                'numero_telefono'   => 'required|string|max:191',
                'sitio_web'         => 'required|url|max:191',
                'nodo_id'           => 'required|integer|min:0|max:9223372036854775807|exists:nodos,id',
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
        if (is_array($this->nodo_id)) {
            $this->merge([
                'nodo_id' => $this->nodo_id['value'],
            ]);
        }
    }
}
