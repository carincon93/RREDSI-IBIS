<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformacionLegalRequest extends FormRequest
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
            'titulo'        => 'required|string|max:191',
            'descripcion'   => 'required|string|max:999999',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->titulo != null) {
            $this->merge([
                'titulo' => filter_var($this->titulo, FILTER_SANITIZE_STRING),
            ]);
        }
    }
}
