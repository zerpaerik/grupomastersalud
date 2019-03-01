<?php

namespace App\Models\Existencias;

use Illuminate\Database\Eloquent\Model;
use App\Models\Config\Sede;

class SalidasProductos extends Model
{

		protected $fillable = ["id_producto", "cantidad", "id_salida"];


}
