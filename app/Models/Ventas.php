<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Ventas extends Model
{
	protected $table="ventas";

    protected $fillable = [
    'id_usuario'
    ];


  public function selectProductos($id)
    {

        $array='';
        $data = \DB::table('ventas_productos')
        ->select('*')
                   // ->where('estatus','=','1')
        ->where('id_venta', $id)
        ->get();
        $descripcion='';
        
        
        foreach ($data as $key => $value) {

          $dataproductos = \DB::table('productos')
          ->select('*')
          ->where('id', $value->id_producto)
          ->get();
          foreach ($dataproductos as $key => $valueproducto) {
            $descripcion.= $valueproducto->nombre.',';
                          # code...
        }
    }

    return substr($descripcion, 0, -1);
              //  return $id;
}

   
}
