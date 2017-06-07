<?php
namespace App\Entities\Interfaces;

interface SearchableEntity {
    /**
     * Retorna um array com os campos que podem ser procurados no banco de dados.
     *
     * @return array
     */
    public static function searchableFields();
}