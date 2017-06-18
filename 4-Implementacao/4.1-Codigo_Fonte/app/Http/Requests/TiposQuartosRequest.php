<?php

namespace App\Http\Requests;

use App\Entities\TipoQuarto;
use Illuminate\Foundation\Http\FormRequest;

class TiposQuartosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TipoQuarto::authorizationVerification($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return TipoQuarto::validationRules($this);
    }

    public function messages()
    {
        return TipoQuarto::validationMessages($this);
    }
}
