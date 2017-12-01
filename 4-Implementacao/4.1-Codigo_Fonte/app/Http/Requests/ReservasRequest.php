<?php

namespace App\Http\Requests;

use App\Entities\Reserva;
use Illuminate\Foundation\Http\FormRequest;

class ReservasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Reserva::authorizationVerification($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Reserva::validationRules($this);
    }

    public function messages()
    {
        return array_merge(
            parent::messages(),
            Reserva::messages($this)
        );
    }


}
