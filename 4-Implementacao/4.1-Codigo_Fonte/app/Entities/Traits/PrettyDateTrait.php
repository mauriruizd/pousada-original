<?php
namespace App\Entities\Traits;

use Carbon\Carbon;

trait PrettyDateTrait
{
    public function setDate($dateString, $attributeName)
    {
        $this->attributes[$attributeName] = $this->prettyDateToDBDate($dateString);
    }

    public function getDate($date)
    {
        return $this->DBDateToPrettyDate($date);
    }

    private function prettyDateToDBDate($dateString)
    {
        return implode('-', array_reverse(explode('/', $dateString))) . ' 00:00:00';
    }

    private function DBDateToPrettyDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}