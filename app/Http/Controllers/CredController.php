<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pacientes\Paciente;
use App\Models\Personal;
use App\Models\Profesionales\Profesional;
use App\Models\Events\{Event, RangoConsulta};
use App\Models\Creditos;
use App\Models\Events;
use App\Models\Ciex;
use App\Models\Historiales;
use App\Models\TipoConsulta;
use Calendar;
use Carbon\Carbon;
use DB;
use PDF;
use App\Models\Existencias\{Producto, Existencia, Transferencia};
use App\Historial;
use App\Consulta;
use App\Cred;
use Toastr;

class CredController extends Controller
{

 
  public function show(Request $request,$id)
  {
    $event = DB::table('events as e')
    ->select('e.id as evento','e.paciente','e.title','e.profesional','e.date','e.time','p.dni','p.direccion','p.telefono','p.fechanac','p.gradoinstruccion','p.ocupacion','p.nombres','p.apellidos','p.id as pacienteId','per.name as nombrePro','per.lastname as apellidoPro','per.id as profesionalId','rg.start_time','rg.end_time','rg.id')
    ->join('pacientes as p','p.id','=','e.paciente')
    ->join('personals as per','per.id','=','e.profesional')
    ->join('rangoconsultas as rg','rg.id','=','e.time')
    ->where('e.id','=',$id)
    ->first();

    $evento= DB::table('events')
    ->select('*')
    ->where('id','=',$id)
    ->first();


    $edad = Carbon::parse($event->fechanac)->age;
    $historial = Historial::where('paciente_id','=',$event->pacienteId)->first();
    $cred = Cred::where('paciente','=',$event->pacienteId)->get();
    $personal = Personal::where('estatus','=',1)->get();
  $productos = Producto::where('almacen','=',2)->where("sede_id", "=", $request->session()->get('sede'))->get();
    $ciex = Ciex::all();
    return view('cred.show',[
      'data' => $event,
      'historial' => $historial,
      'cred' => $cred,
      'personal' => $personal,
    'productos' => $productos,
      'ciex' => $ciex,
      'edad' => $edad,
      'evento' => $evento
    ]);
  }


    public function create(Request $request)
    {

          
    		Cred::create([
		    	'paciente' =>$request->paciente,
				'peso' =>$request->peso,
				'talla' =>$request->talla,
				'edad' =>$request->edad,
				'perim' =>$request->perim
				
			]);

			

			
			
			

		Toastr::success('Registrado Exitosamente.', 'CRED!', ['progressBar' => true]);

       return back();

		
    }

  



}