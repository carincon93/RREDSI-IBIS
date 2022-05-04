<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RespuestaRequest extends FormRequest
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
            'titulo'      => 'required|string|min:5',
            'descripcion' => 'required|string|min:10',
            'documento'   => 'nullable|mimes:pdf|max:1000000',
        ];
    }
}
