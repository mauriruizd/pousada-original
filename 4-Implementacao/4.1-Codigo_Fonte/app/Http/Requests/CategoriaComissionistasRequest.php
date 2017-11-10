<?php

namespace App\Http\Requests;

use App\Entities\CategoriaComissionista;
use Illuminate\Foundation\Http\FormRequest;

class CategoriaComissionistasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return CategoriaComissionista::authorizationVerification($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return CategoriaComissionista::validationRules($this);
    }
}
