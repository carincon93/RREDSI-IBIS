<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmbienteFormacionRequest extends FormRequest
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
            'nombre'                                => 'required|string|max:191 ',
            'tipo'                                  => 'required|string|max:191',
            'capacidad_aprox'                       => 'required|integer|min:0|max:2147483647',
            'foto'                                  => 'nullable|mimes:jpeg,png,bmp,tiff |max:4000000',
            'nombre_responsable'                    => 'required|string|max:191',
            'correo_responsable'                    => 'required|email|max:191',
            'celular_responsable'                   => 'required|string|max:191',
            'facultad_id'                           => 'required|min:0|max:9223372036854775807|exists:facultades,id',
            'disciplina_subarea_conocimiento_id.*'  => 'required|min:0|max:9223372036854775807|exists:disciplinas_subarea_conocimiento,id',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (is_array($this->disciplina_subarea_conocimiento_id)) {
            if (isset($this->disciplina_subarea_conocimiento_id['value']) && is_numeric($this->disciplina_subarea_conocimiento_id['value'])) {
                $this->merge([
                    'disciplina_subarea_conocimiento_id' => $this->disciplina_subarea_conocimiento_id['value'],
                ]);
            } else {
                $disciplinas = [];
                foreach ($this->disciplina_subarea_conocimiento_id as $disciplina) {
                    if (is_array($disciplina)) {
                        array_push($disciplinas, $disciplina['value']);
                    }
                }
                $this->merge(['disciplina_subarea_conocimiento_id' => $disciplinas]);
            }
        }

        if (is_array($this->facultad_id)) {
            $this->merge([
                'facultad_id' => $this->facultad_id['value'],
            ]);
        }
    }
}
