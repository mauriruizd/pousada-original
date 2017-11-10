<?php

namespace App\Http\Requests;

use App\Entities\Souvenir;
use Illuminate\Foundation\Http\FormRequest;

class SouvenirsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Souvenir::authorizationVerification($this);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Souvenir::validationRules($this);
    }
}
