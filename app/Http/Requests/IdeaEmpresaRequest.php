<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdeaEmpresaRequest extends FormRequest
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
            'nombre'            => 'required|string|max:191|min:5',
            'descripcion'       => 'required|string|max:5000|min:10',
            'tipo'              => 'required|string|max:191',
            'tiene_equipos'     => 'boolean',
            'equipos'           => 'nullable|json',
            'tiene_recursos'    => 'boolean',
            'recursos'          => 'nullable|integer',
            'condicion'         => 'required|string|max:191',
            'es_publica'        => 'nullable|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (is_array($this->tipo)) {
            $this->merge([
                'tipo' => $this->tipo['value'],
            ]);
        }

        if (is_array($this->tiene_equipos)) {
            $this->merge([
                'tiene_equipos' => $this->tiene_equipos['value'],
            ]);
        }

        if (is_array($this->tiene_recursos)) {
            $this->merge([
                'tiene_recursos' => $this->tiene_recursos['value'],
            ]);
        }

        if (is_array($this->es_publica)) {
            $this->merge([
                'es_publica' => $this->es_publica['value'],
            ]);
        }

        if (is_array($this->condicion)) {
            $this->merge([
                'condicion' => $this->condicion['value'],
            ]);
        }
    }
}
