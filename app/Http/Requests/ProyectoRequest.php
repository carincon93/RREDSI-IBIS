<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoRequest extends FormRequest
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
                'main_image'                            => 'nullable|mimes:jpeg,png,bmp,tiff |max:4000000',
                'titulo'                                => 'required',
                'fecha_inicio'                          => 'required|date|date_format:Y-m-d|before:fecha_finalizacion',
                'fecha_finalizacion'                    => 'required|date|date_format:Y-m-d|after:fecha_inicio',
                'resumen'                               => 'required',
                'palabras_clave'                        => 'required|json',
                'file'                                  => 'nullable|max:20000|file|mimetypes:application/pdf',
                'objetivo_general'                      => 'required',
                'privado'                               => 'required|boolean',
                'tipo_proyecto_id'                      => 'required|min:0|max:9223372036854775807|exists:tipos_proyecto,id',
                'semillero_investigacion_id.*'          => 'min:0|max:9223372036854775807|exists:semilleros_investigacion,id',
                'linea_investigacion_id.*'              => 'required|min:0|max:9223372036854775807|exists:lineas_investigacion,id',
                'disciplina_subarea_conocimiento_id.*'  => 'required|min:0|max:9223372036854775807|exists:disciplinas_subarea_conocimiento,id',
                'programa_academico_id.*'               => 'required|min:0|max:9223372036854775807|exists:programas_academicos,id',
                'facultad_id'                           => 'required|min:0|max:9223372036854775807|exists:facultades,id',
                'user_id.*'                             => 'required|min:0|max:9223372036854775807|exists:users,id',
            ];
        } else {
            return [
                'main_image'                            => 'mimes:jpeg,png,bmp,tiff|max:4000000',
                'titulo'                                => 'required',
                'fecha_inicio'                          => 'required|date|date_format:Y-m-d|before:fecha_finalizacion',
                'fecha_finalizacion'                    => 'required|date|date_format:Y-m-d|after:fecha_inicio',
                'resumen'                               => 'required',
                'palabras_clave'                        => 'required|json',
                'file'                                  => 'file|max:10000000|mimetypes:application/pdf',
                'objetivo_general'                      => 'required',
                'privado'                               => 'required|boolean',
                'tipo_proyecto_id'                      => 'required|min:0|max:9223372036854775807|exists:tipos_proyecto,id',
                'semillero_investigacion_id.*'          => 'min:0|max:9223372036854775807|exists:semilleros_investigacion,id',
                'linea_investigacion_id.*'              => 'required|min:0|max:9223372036854775807|exists:lineas_investigacion,id',
                'disciplina_subarea_conocimiento_id.*'  => 'required|min:0|max:9223372036854775807|exists:disciplinas_subarea_conocimiento,id',
                'programa_academico_id.*'               => 'required|min:0|max:9223372036854775807|exists:programas_academicos,id',
                'facultad_id'                           => 'required|min:0|max:9223372036854775807|exists:facultades,id',
                'user_id.*'                             => 'required|min:0|max:9223372036854775807|exists:users,id',
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
        if (is_array($this->user_id)) {
            if (isset($this->user_id['value']) && is_numeric($this->user_id['value'])) {
                $this->merge([
                    'user_id' => $this->user_id['value'],
                ]);
            } else {
                $users = [];
                foreach ($this->user_id as $user) {
                    if (is_array($user)) {
                        array_push($users, $user['value']);
                    }
                }
                $this->merge(['user_id' => $users]);
            }
        }

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

        if (is_array($this->semillero_investigacion_id)) {
            if (isset($this->semillero_investigacion_id['value']) && is_numeric($this->semillero_investigacion_id['value'])) {
                $this->merge([
                    'semillero_investigacion_id' => $this->semillero_investigacion_id['value'],
                ]);
            } else {
                $semilleros = [];
                foreach ($this->semillero_investigacion_id as $semillero) {
                    if (is_array($semillero)) {
                        array_push($semilleros, $semillero['value']);
                    }
                }
                $this->merge(['semillero_investigacion_id' => $semilleros]);
            }
        }

        if (is_array($this->tipo_proyecto_id)) {
            $this->merge([
                'tipo_proyecto_id' => $this->tipo_proyecto_id['value'],
            ]);
        }

        if (is_array($this->facultad_id)) {
            $this->merge([
                'facultad_id' => $this->facultad_id['value'],
            ]);
        }

        if (is_array($this->privado)) {
            $this->merge([
                'privado' => $this->privado['value'] == '1' ? 1 : 0,
            ]);
        }
    }
}
