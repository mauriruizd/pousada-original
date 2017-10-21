<?php
namespace App\Entities\Traits;

use Carbon\Carbon;

trait PrettyDateTrait
{
    public function setDate($dateString, $attributeName)
    {
        $this->attributes[$attributeName] = implode('-', array_reverse(explode('/', $dateString))) . ' 00:00:00';
    }

    public function getDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}