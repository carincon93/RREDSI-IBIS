<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstudioRequest extends FormRequest
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
            'graduado'                  => ['boolean'],
            'institucion_educativa'     => ['required', 'string', 'max:191'],
            'programa_academico'        => ['required', 'string', 'max:191'],
            'year'                      => ['required', 'integer', 'min:0', 'max:2100'],
        ];
    }
}
