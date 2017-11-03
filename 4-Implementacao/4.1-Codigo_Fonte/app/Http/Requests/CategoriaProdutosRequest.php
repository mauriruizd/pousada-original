<?php

namespace App\Http\Requests;

use App\Entities\Categoria;
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
        return Categoria::authorizationVerification($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Categoria::validationRules($this);
    }
}
