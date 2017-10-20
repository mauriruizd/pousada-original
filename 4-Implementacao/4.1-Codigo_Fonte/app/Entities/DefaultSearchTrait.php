<?php
 namespace App\Entities;

 trait DefaultSearchTrait
 {
     public function scopeSearch($q, $search)
     {
         if (method_exists($this, 'searchableFields') && !empty($search)) {
             foreach ($this->searchableFields() as $field) {
                 $q = $q->orWhere($field, 'like', '%' . $search . '%');
             }
         }
         return $q;
     }
 }