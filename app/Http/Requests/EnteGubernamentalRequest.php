<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnteGubernamentalRequest extends FormRequest
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
            'nombreEntidad'         => 'required|string|min:5',
            'nit'                   => 'required|int|min:5',
            'telefono'              => 'required|int|min:10',
            'ciudad'                => 'required|string',
            'direccion'             => 'required|string',

        ];
    }
}
