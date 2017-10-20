<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
abstract class GeographicDataSeeder extends Seeder
{
    protected function fill($tableName, $data)
    {
        foreach (array_chunk(array_map(function($item) {
            return $this->populate($this->keys, explode(",", $item));
        }, explode("\n", $data)), 1000) as $chunk) {
            DB::table($tableName)->insert($chunk);
        }
    }

    protected function populate($keys, $values)
    {
        $result = [];
        foreach ($keys as $index => $key) {
            $result[$key] = $values[$index];
        }
        return $result;
    }
}
