<?php

namespace App\Http\Requests;

use App\Entities\FonteReserva;
use Illuminate\Foundation\Http\FormRequest;

class FonteReservasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return FonteReserva::authorizationVerification($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return FonteReserva::validationRules($this);
    }
}
