<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConvocatoriaRequest extends FormRequest
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
            'nombre'                     => 'required|string|min:5',
            'entidad'                    => 'required|string|min:5',
            'detalles'                   => 'string|min:10',
            'fecha_inicio'               => 'required|date',
            'fecha_finalizacion'         => 'required|date',
            'image'                      => 'nullable|mimes:jpeg,png|max:4000000',
            'link_mas_informacion'       => 'required|string|min:10',
        ];
    }
}
