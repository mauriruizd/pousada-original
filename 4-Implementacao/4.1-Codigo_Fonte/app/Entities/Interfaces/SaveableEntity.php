<?php
namespace App\Entities\Interfaces;

interface SaveableEntity
{
    /**
     * Retorna array de nomes de campos salváveis no BD.
     * @return array
     */
    public function whitelist();
}