<?php
namespace App\Entities\Interfaces;

use Illuminate\Http\Request;

interface EntityValidation {
    /**
     * Retorna array com regras para utilizar pelo Validator.
     *
     * @param Request $request
     * @return array
     */
    public static function validationRules(Request $request);

    /**
     * Comprova autorização para realizar a operação.
     *
     * @param Request $request
     * @return boolean
     */
    public static function authorizationVerification(Request $request);
}