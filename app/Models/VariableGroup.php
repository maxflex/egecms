<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariableGroup extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];
}
