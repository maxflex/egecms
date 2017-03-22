<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariableGroup extends Model
{
    public static function getIds()
    {
        $ids = self::pluck('id')->all();
        $ids[] = [
            'id'    => null,
            'title' => 'Остальные'
        ];
        return $ids;
    }
}
