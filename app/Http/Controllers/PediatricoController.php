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
use App\Pediatrico;
use Toastr;

class PediatricoController extends Controller
{

 
 
  public function show(Request $request,$id,$id2)
  {

 
    $event = DB::table('events as e')
    ->select('e.id as evento','e.paciente','e.title','e.profesional','e.date','e.time','p.dni','p.direccion','p.telefono','p.fechanac','p.gradoinstruccion','p.ocupacion','p.nombres','p.apellidos','p.id as pacienteId','per.name as nombrePro','per.lastname as apellidoPro','per.id as profesionalId','rg.start_time','rg.end_time','rg.id')
    ->join('pacientes as p','p.id','=','e.paciente')
    ->join('personals as per','per.id','=','e.profesional')
    ->join('rangoconsultas as rg','rg.id','=','e.time')
    ->where('e.id','=',$id2)
    ->first();

    $evento= DB::table('events')
    ->select('*')
    ->where('id','=',$id)
    ->first();


    $edad = Carbon::parse($event->fechanac)->age;
    $historial = Historial::where('paciente_id','=',$event->pacienteId)->first();
    $consultas = Pediatrico::where('paciente','=',$event->pacienteId)->get();
    $personal = Personal::where('estatus','=',1)->get();
  $productos = Producto::where('almacen','=',2)->where("sede_id", "=", $request->session()->get('sede'))->get();
    $ciex = Ciex::all();
    return view('pediatrico.show',[
      'data' => $event,
      'historial' => $historial,
      'consultas' => $consultas,
      'personal' => $personal,
    'productos' => $productos,
      'ciex' => $ciex,
      'edad' => $edad,
      'evento' => $evento
    ]);
  }

   public function create(Request $request)
    {

    		Pediatrico::create([
		    	'mp' =>$request->mp,
				'tenf' =>$request->tenf,
				'mot' =>$request->mot,
				'rel' =>$request->rel,
				'ape' =>$request->ape,
				'sed' =>$request->sed,
				'orin'=>$request->orin,
				'hec' =>$request->hec,
				'ram' =>$request->ram,
				'hosp' =>$request->hosp,
				'cir' =>$request->cir,
				'vac' =>$request->vac,
				'ap' =>$request->ap,
				'edad' =>$request->edad,
				'peso' =>$request->peso,
				'talla' =>$request->talla,
				'pri' =>$request->pri,
				'pa' =>$request->pa,
				'sat' =>$request->sat,
				'ag' =>$request->ag,
				'cab' =>$request->cab,
				'ad' =>$request->ad,
				'sn' =>$request->sn,
				'piel' =>$request->piel,
				'tor' =>$request->tor,
				'sc' =>$request->sc,
				'sg' =>$request->sg,
				'al' =>$request->al,
				'hall' =>$request->hall,
				'diag' =>$request->diag,
				'plan' =>$request->plan,
				'exa' =>$request->exa,
				'trat' =>$request->trat,
				'prox' =>$request->prox,
				'paciente' =>$request->paciente
					
			]);

	

		Toastr::success('Registrado Exitosamente.', 'Consulta Pediatrica!', ['progressBar' => true]);

       return back();

		
    }





}