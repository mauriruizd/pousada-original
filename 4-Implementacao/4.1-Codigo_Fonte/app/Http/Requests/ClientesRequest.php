<?php

namespace App\Http\Requests;

use App\Entities\Cliente;
use Illuminate\Foundation\Http\FormRequest;

class ClientesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Cliente::authorizationVerification($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Cliente::validationRules($this);
    }

    protected function prepareForValidation()
    {
        $data = $this->all();
        $data['cpf'] = str_replace("-", "", $data['cpf']);
        $this->replace($data);
    }


}
