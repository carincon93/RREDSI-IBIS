<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrabajoGradoRequest extends FormRequest
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
            'titulo'                                => 'required|string|max:191',
            'tipo'                                  => 'required|string|max:191',
            'autores'                               => 'required|json',
            'nota'                                  => 'required|between:0,99.99|max:9999999999',
            'mentores'                              => 'required|json',
            'disciplina_subarea_conocimiento_id'    => 'required|integer|min:0|max:9999999999|exists:disciplinas_subarea_conocimiento,id',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->autores != null) {
            $this->merge([
                'autores' => json_encode(explode(',', $this->autores), true),
            ]);
        }

        if ($this->mentores != null) {
            $this->merge([
                'mentores' => json_encode(explode(',', $this->mentores), true),
            ]);
        }
    }
}
