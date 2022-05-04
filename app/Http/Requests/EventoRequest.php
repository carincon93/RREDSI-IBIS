<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoRequest extends FormRequest
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
            'nombre'              => 'required|string|max:191',
            'ubicacion'           => 'required|string|max:191',
            'descripcion'         => 'required',
            'fecha_inicio'        => 'required|date|date_format:Y-m-d|before:fecha_finalizacion',
            'fecha_finalizacion'  => 'required|date|date_format:Y-m-d|after:fecha_inicio',
            'link_registro'       => 'required|url|max:255',
            'info_link'           => 'required|url|max:255',
            'objetivos'           => 'required',
            'cronograma'          => 'required',
            'afiche'              => 'nullable|mimes:jpeg,png,bmp,tif|max:4000000',
            'imagen_principal'    => 'nullable|mimes:jpeg,png,bmp,tif|max:4000000',
        ];
    }
}
