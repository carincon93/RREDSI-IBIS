<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ProyectoEventoRredsiDepartamentalRequest extends FormRequest
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
            'tipo_presentacion'                     => 'required|string|max:191',
            'modalidad_proyecto'                    => 'nullable|string|max:191',
            'carta_aval'                            => 'nullable|file|max:10000000|mimetypes:application/pdf',
            'carta_poster'                          => 'nullable|file|max:10000000|mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'documento_proyecto_finalizado'         => 'nullable|file|max:10000000|mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'autorizacion_memorias'                 => 'required|boolean',
            'autorizacion_tratamiento_datos'        => 'required|boolean',
            'area_conocimiento'                     => 'required|string|max:191',
            'primer_ponente_id'                     => 'required|integer|min:0|max:9223372036854775807|exists:users,id',
            'segundo_ponente_id'                    => 'required|integer|min:0|max:9223372036854775807|exists:users,id',
            'programa_academico_primer_ponente_id'  => 'required|integer|min:0|max:9223372036854775807|exists:programas_academicos,id',
            'programa_academico_segundo_ponente_id' => 'required|integer|min:0|max:9223372036854775807|exists:programas_academicos,id',
            'semillero_investigacion_id'            => 'required|integer|min:0|max:9223372036854775807|exists:semilleros_investigacion,id',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (is_array($this->tipo_presentacion)) {
            $this->merge([
                'tipo_presentacion' => $this->tipo_presentacion['value'],
            ]);
        }

        if (is_array($this->modalidad_proyecto)) {
            $this->merge([
                'modalidad_proyecto' => $this->modalidad_proyecto['value'],
            ]);
        }

        if (is_array($this->area_conocimiento)) {
            $this->merge([
                'area_conocimiento' => $this->area_conocimiento['value'],
            ]);
        }

        if (is_array($this->primer_ponente_id)) {
            $this->merge([
                'primer_ponente_id' => $this->primer_ponente_id['value'],
            ]);
        }

        if (is_array($this->primer_ponente_id)) {
            $this->merge([
                'primer_ponente_id' => $this->primer_ponente_id['value'],
            ]);
        }

        if (is_array($this->segundo_ponente_id)) {
            $this->merge([
                'segundo_ponente_id' => $this->segundo_ponente_id['value'],
            ]);
        }

        if (is_array($this->programa_academico_primer_ponente_id)) {
            $this->merge([
                'programa_academico_primer_ponente_id' => $this->programa_academico_primer_ponente_id['value'],
            ]);
        }

        if (is_array($this->programa_academico_segundo_ponente_id)) {
            $this->merge([
                'programa_academico_segundo_ponente_id' => $this->programa_academico_segundo_ponente_id['value'],
            ]);
        }

        if (is_array($this->semillero_investigacion_id)) {
            $this->merge([
                'semillero_investigacion_id' => $this->semillero_investigacion_id['value'],
            ]);
        }

        if (is_array($this->semillero_investigacion_id)) {
            $this->merge([
                'semillero_investigacion_id' => $this->semillero_investigacion_id['value'],
            ]);
        }

        if (is_array($this->autorizacion_memorias)) {
            $this->merge([
                'autorizacion_memorias' => $this->autorizacion_memorias['value'] == '1' ? 1 : 0,
            ]);
        }

        if (is_array($this->autorizacion_tratamiento_datos)) {
            $this->merge([
                'autorizacion_tratamiento_datos' => $this->autorizacion_tratamiento_datos['value'] == '1' ? 1 : 0,
            ]);
        }
    }
}
