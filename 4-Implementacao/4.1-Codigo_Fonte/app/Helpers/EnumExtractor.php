<?php
namespace App\Helpers;

class EnumExtractor {
    /**
     * Retorna array com chave-valor de uma Enum
     * @param $class
     * @return array
     */
    public static function title($class)
    {
        $select = [];
        foreach (get_class_vars($class) as $key => $value) {
            $select[$key] = title_case($value);
        }
        return $select;
    }
}