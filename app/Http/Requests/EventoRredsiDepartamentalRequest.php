<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoRredsiDepartamentalRequest extends FormRequest
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
                'afiche'                                => 'nullable|mimes:jpeg,png,bmp,tiff|max:4000000',
                'titulo'                                => 'required',
                'fecha_inicio'                          => 'required|date|date_format:Y-m-d',
                'fecha_finalizacion'                    => 'required|date|date_format:Y-m-d',
                'introduccion'                          => 'required',
                'formato_guia_ponencia'                 => 'nullable|max:10000000|file|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'carta_aval_ponencia'                   => 'nullable|max:10000000|file|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'plantilla_presentacion_ponencia'       => 'nullable|max:10000000|file|mimetypes:application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'formato_guia_poster'                   => 'nullable|max:10000000|file|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'carta_aval_poster'                     => 'nullable|max:10000000|file|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'plantilla_presentacion_poster'         => 'nullable|max:10000000|file|mimetypes:application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'objetivos'                             => 'required',
                'cronograma'                            => 'required',
                'areas_conocimiento'                    => 'required',
                'estado'                                => 'required|boolean',
                'institucion_educativa_id'              => 'required|min:0|max:9223372036854775807|exists:instituciones_educativas,id',
            ];
        } else {
            return [
                'afiche'                                => 'mimes:jpeg,png,bmp,tiff|max:4000000',
                'titulo'                                => 'required',
                'fecha_inicio'                          => 'required|date|date_format:Y-m-d',
                'fecha_finalizacion'                    => 'required|date|date_format:Y-m-d',
                'introduccion'                          => 'required',
                'objetivos'                             => 'required',
                'cronograma'                            => 'required',
                'areas_conocimiento'                    => 'required',
                'estado'                                => 'required|boolean',
                'formato_guia_ponencia'                 => 'file|max:10000000|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'carta_aval_ponencia'                   => 'file|max:10000000|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'plantilla_presentacion_ponencia'       => 'file|max:10000000|mimetypes:application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'formato_guia_poster'                   => 'file|max:10000000|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'carta_aval_poster'                     => 'file|max:10000000|mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'plantilla_presentacion_poster'         => 'file|max:10000000|mimetypes:application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'institucion_educativa_id'              => 'required|min:0|max:9223372036854775807|exists:instituciones_educativas,id',
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
        if (is_array($this->institucion_educativa_id)) {
            $this->merge([
                'institucion_educativa_id' => $this->institucion_educativa_id['value'],
            ]);
        }

        if (is_array($this->estado)) {
            $this->merge([
                'estado' => $this->estado['value'] == '1' ? 1 : 0,
            ]);
        }
    }
}
