<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['text'];

    public static function getIds($tags)
    {
        return collect($tags)->pluck('id')->all();
    }
}
