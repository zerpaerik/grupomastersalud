<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoConsulta extends Model
{
    protected $fillable = [
    	'detalle', 'precio','usuario'
    ];
}
