<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SemilleroInvestigacionRequest extends FormRequest
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
            'nombre'                                => 'required|string|max:191',
            'nombre_mentor'                         => 'required|string|max:191',
            'correo_mentor'                         => 'required|email|max:191',
            'celular_mentor'                        => 'required|integer|min:0|max:9223372036854775807',
            'objetivo_general'                      => 'required',
            'mision'                                => 'required',
            'vision'                                => 'required',
            'proyeccion_regional'                   => 'required',
            'estrategia_produccion_conocimiento'    => 'required',
            'tematica_investigacion'                => 'required|json',
            'programa_academico_id.*'               => 'required|integer|min:0|max:9223372036854775807|exists:programas_academicos,id',
            'disciplina_subarea_conocimiento_id.*'  => 'required|integer|min:0|max:9223372036854775807|exists:disciplinas_subarea_conocimiento,id',
            'grupo_investigacion_id'                => 'required|integer|min:0|max:9223372036854775807|exists:grupos_investigacion,id',
            'linea_investigacion_id.*'              => 'required|integer|min:0|max:9223372036854775807|exists:lineas_investigacion,id',
            'fecha_creacion'                        => 'required|date|date_format:Y-m-d',
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

        if (is_array($this->linea_investigacion_id)) {
            if (isset($this->linea_investigacion_id['value']) && is_numeric($this->linea_investigacion_id['value'])) {
                $this->merge([
                    'linea_investigacion_id' => $this->linea_investigacion_id['value'],
                ]);
            } else {
                $lineas = [];
                foreach ($this->linea_investigacion_id as $linea) {
                    if (is_array($linea)) {
                        array_push($lineas, $linea['value']);
                    }
                }
                $this->merge(['linea_investigacion_id' => $lineas]);
            }
        }

        if (is_array($this->programa_academico_id)) {
            if (isset($this->programa_academico_id['value']) && is_numeric($this->programa_academico_id['value'])) {
                $this->merge([
                    'programa_academico_id' => $this->programa_academico_id['value'],
                ]);
            } else {
                $programas = [];
                foreach ($this->programa_academico_id as $programa) {
                    if (is_array($programa)) {
                        array_push($programas, $programa['value']);
                    }
                }
                $this->merge(['programa_academico_id' => $programas]);
            }
        }

        if (is_array($this->grupo_investigacion_id)) {
            $this->merge([
                'grupo_investigacion_id' => $this->grupo_investigacion_id['value'],
            ]);
        }
    }
}
