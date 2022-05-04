<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NodoRequest extends FormRequest
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
                'departamento'      => 'required|string|unique:nodos,departamento,' . $this->route('nodo')->id . ',id|max:191',
                'logo'              => 'mimes:jpeg,png,bmp,tiff|max:4000000',
            ];
        } else {
            return [
                'departamento'      => 'required|string|unique:nodos,departamento|max:191',
                'logo'              => 'mimes:jpeg,png,bmp,tiff|max:4000000',
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
        if (is_array($this->departamento)) {
            $this->merge([
                'departamento' => $this->departamento['value'],
            ]);
        }
    }
}
