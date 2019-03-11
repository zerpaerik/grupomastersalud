<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class VentasProductos extends Model
{
	protected $table="ventas_productos";

    protected $fillable = [
    'id_venta','id_producto','cantidad','monto','paciente'
    ];

     public function montoVenta($id)
    {
        $data = \DB::table('ventas_productos')
        ->select(DB::raw('SUM(monto) as monto'))
        ->where('id_venta', $id)->first();
        
        $monto=$data->monto;
       
      return $monto;
   }

   
}
