<?php

namespace App\Http\Requests;

use App\Entities\Comissionista;
use Illuminate\Foundation\Http\FormRequest;

class ComissionistasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Comissionista::authorizationVerification($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Comissionista::validationRules($this);
    }
}
