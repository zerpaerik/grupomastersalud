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
				'perim' =>$request->perim,
        'bcg' =>$request->bcg,
        'hvb' =>$request->hvb,
        'atp1' =>$request->atp1,
        'atp2' =>$request->atp2,
        'atp3' =>$request->atp3,
        'pent1' =>$request->pent1,
        'pent2' =>$request->pent2,
        'pent3' =>$request->pent3,
        'neu1' =>$request->neu1,
        'neu2' =>$request->neu2,
        'neu3' =>$request->neu3,
        'rot1' =>$request->rot1,
        'rot2' =>$request->rot2,
        'rot3' =>$request->rot3,
        'rot4' =>$request->rot4,
        'ano1' =>$request->ano1,
        'ano2' =>$request->ano2,
        'ano3' =>$request->ano3,
        'ano4' =>$request->ano4,
        'spr1' =>$request->spr1,
        'spr2' =>$request->spr2,
        'vari' =>$request->vari,
        'antia' =>$request->antia,
        'ref1' =>$request->ref1,
        'ref2' =>$request->ref2,
        'ref3' =>$request->ref3,
        'ref4' =>$request->ref4,
        'otra1' =>$request->ot1,
        'otra2' =>$request->ot2,
        'otra3' =>$request->ot3,
        'ot1' =>$request->ot1,
        'ot2' =>$request->ot2,
        'ot3' =>$request->ot3,
        'observs' =>$request->observs
				
			]);

			

			
			
			

		Toastr::success('Registrado Exitosamente.', 'CRED!', ['progressBar' => true]);

       return back();

		
    }

  



}