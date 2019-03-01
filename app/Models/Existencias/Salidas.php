<?php

namespace App\Models\Existencias;

use Illuminate\Database\Eloquent\Model;
use App\Models\Config\Sede;

class Salidas extends Model
{

		protected $fillable = ["paciente", "sede", "servicio","usuario"];

    public function getSedeIdAttribute($value){
        return Sede::where('id', '=', $value)->get()->first()->name;
    }    

}
