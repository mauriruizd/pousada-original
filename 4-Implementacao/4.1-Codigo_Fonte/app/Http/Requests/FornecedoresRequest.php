<?php

namespace App\Http\Requests;

use App\Entities\Fornecedor;
use Illuminate\Foundation\Http\FormRequest;

class FornecedoresRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Fornecedor::authorizationVerification($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Fornecedor::validationRules($this);
    }
}
