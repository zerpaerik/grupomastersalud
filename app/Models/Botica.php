<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Botica extends Model
{
    protected $fillable = [
    	'nombre','responsable','direccion','estatus','usuario'
    ];

   
}
