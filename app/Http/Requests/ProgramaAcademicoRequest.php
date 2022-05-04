<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramaAcademicoRequest extends FormRequest
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
            'nombre'                => 'required|string|max:191',
            'nivel_academico'       => 'required|string|max:191',
            'modalidad'             => 'required|string|max:191',
            'jornada'               => 'required|string|max:191',
            'facultad_id'           => 'required|integer|min:0|max:9223372036854775807|exists:facultades,id',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (is_array($this->nivel_academico)) {
            $this->merge([
                'nivel_academico' => $this->nivel_academico['value'],
            ]);
        }

        if (is_array($this->modalidad)) {
            $this->merge([
                'modalidad' => $this->modalidad['value'],
            ]);
        }

        if (is_array($this->jornada)) {
            $this->merge([
                'jornada' => $this->jornada['value'],
            ]);
        }

        if (is_array($this->facultad_id)) {
            $this->merge([
                'facultad_id' => $this->facultad_id['value'],
            ]);
        }
    }
}
