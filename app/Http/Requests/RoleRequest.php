<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name'              => 'required|string|max:255',
            'permission_id.*'   => 'required|min:0|max:9223372036854775807|exists:permissions,id',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (is_array($this->permission_id)) {
            if (isset($this->permission_id['value']) && is_numeric($this->permission_id['value'])) {
                $this->merge([
                    'permission_id' => $this->permission_id['value'],
                ]);
            } else {
                $permissions = [];
                foreach ($this->permission_id as $permission) {
                    if (is_array($permission)) {
                        array_push($permissions, $permission['value']);
                    }
                }
                $this->merge(['permission_id' => $permissions]);
            }
        }
    }
}
