<?php

namespace App\Helpers;

use Collective\Html\FormFacade as Form;

class FormSelectCreator {
    public static function fromEntity(
        $idField,
        $valueField,
        $entityCollection,
        $fieldName,
        $selectedValue = null,
        $params = []
    )
    {
        $idGetter = 'get' . $idField;
        $valueGetter = 'get' . $valueField;
        $select = [];
        foreach ($entityCollection as $entity) {
            $select[$entity->$idGetter()] = $entity->$valueGetter();
        }
        return Form::select($fieldName, $select, $selectedValue, $params);
    }
}