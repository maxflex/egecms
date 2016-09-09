<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $attributes = [
        'name' => 'новая переменная'
    ];
    
    protected $fillable = [
        'name',
        'html',
        'desc'
    ];
}
