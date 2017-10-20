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
        $select = [];
        foreach ($entityCollection as $entity) {
            $select[$entity->$idField] = $entity->$valueField;
        }
        return Form::select($fieldName, $select, $selectedValue, $params);
    }
}