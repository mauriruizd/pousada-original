<?php

namespace App\Http\Requests;

use App\Entities\CategoriaProduto;
use Illuminate\Foundation\Http\FormRequest;

class CategoriaProdutosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return CategoriaProduto::authorizationVerification($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return CategoriaProduto::validationRules($this);
    }
}
