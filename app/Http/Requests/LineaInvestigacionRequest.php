<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LineaInvestigacionRequest extends FormRequest
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
            'nombre'                    => 'required|string|max:191',
            'objetivos'                 => 'required',
            'mision'                    => 'required',
            'vision'                    => 'required',
            'logros'                    => 'required',
            'area_conocimiento_id'      => 'required|integer|min:0|max:9223372036854775807|exists:areas_conocimiento,id',
            'grupo_investigacion_id'    => 'required|integer|min:0|max:9223372036854775807|exists:grupos_investigacion,id',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (is_array($this->area_conocimiento_id)) {
            $this->merge([
                'area_conocimiento_id' => $this->area_conocimiento_id['value'],
            ]);
        }

        if (is_array($this->grupo_investigacion_id)) {
            $this->merge([
                'grupo_investigacion_id' => $this->grupo_investigacion_id['value'],
            ]);
        }
    }
}
