<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoInvestigacionRequest extends FormRequest
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
        return [
            'nombre'                   => 'required|string|max:191',
            'email'                    => 'required|email|max:191',
            'lider'                    => 'required|string|max:191',
            'gruplac'                  => 'url|max:191',
            'codigo_minciencias'       => 'required|string|max:191',
            'categoria_minciencias'    => 'max:1',
            'sitio_web'                => 'url|max:191',
            'facultad_id'              => 'required|integer|min:0|max:9223372036854775807|exists:facultades,id',

        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (is_array($this->categoria_minciencias)) {
            $this->merge([
                'categoria_minciencias' => $this->categoria_minciencias['value'],
            ]);
        }

        if (is_array($this->facultad_id)) {
            $this->merge([
                'facultad_id' => $this->facultad_id['value'],
            ]);
        }
    }
}
