<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['text'];

    public static function pluckIds($tags = [])
    {
        return Collect($tags)->pluck('id')->all();
    }
}
