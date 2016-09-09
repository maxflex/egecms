<?php

namespace App\Models\Service;
use DB;

class Factory
{
    public static function get($table, $select = null)
    {
        $query = DB::connection('factory')->table($table);

        if ($select) {
            $query->select('id', $select);
        }

        return $query->get();
    }

    public static function json($table, $select = null)
    {
        $data = static::get($table, $select);
        return json_encode($data);
    }
}
