<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentasProductos extends Model
{
	protected $table="ventas_productos";

    protected $fillable = [
    'id_venta','id_producto','cantidad','monto','paciente'
    ];

   
}
