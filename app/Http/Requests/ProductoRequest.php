<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'nombre'      => 'required|string|max:191|min:5',
            'descripcion' => 'required|string|max:191|min:10',
            'image'       => 'nullable|mimes:jpeg,png|max:1024',
        ];
    }
}
