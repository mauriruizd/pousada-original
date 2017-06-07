<?php
namespace App\Entities\Interfaces;

use Illuminate\Http\Request;

interface EntityValidation {
    /**
     * Retorna array com regras para utilizar pelo Validator.
     *
     * @return array
     */
    public static function validationRules();

    /**
     * Comprova autorização para realizar a operação.
     *
     * @param Request $request
     * @return boolean
     */
    public static function authorizationVerification(Request $request);
}