<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Models\Atenciones;
use App\Models\Profesionales\Profesional;
use App\Models\Debitos;
use App\Models\Visitas;
use App\Models\Analisis;
use App\Models\Botica;
use Auth;
use Toastr;

class VisitasController extends Controller

{

	public function index(){
        $inicio = Carbon::now()->toDateString();
        $final = Carbon::now()->addDay()->toDateString();
        $visitas = $this->elasticSearch($inicio,$final);
        $profesionales = Profesional::where("estatus", '=', 1)->get();

        return view('visitas.index', ["visitas" => $visitas,"profesionales" => $profesionales]);
	}

    public function search(Request $request)
    {
        $visitas = $this->elasticSearch($request->inicio,$request->final);
        return view('visitas.search', ["visitas" => $visitas]); 
    }


  private function elasticSearch($initial, $final)
  { 
        $visitas = DB::table('visitas as a')
        ->select('a.id','a.id_profesional','a.id_botica','a.id_visitador','a.created_at','b.name','b.apellidos','c.name as nomvi','c.lastname as apevi','b.centro','b.especialidad','d.name as centro','e.nombre as especialidad','bo.nombre as botica')
        ->join('profesionales as b','b.id','a.id_profesional')
        ->join('users as c','c.id','a.id_visitador')
        ->join('centros as d','b.centro','d.id')
        ->join('especialidades as e','e.id','b.especialidad')
        ->join('boticas as bo','bo.id','a.id_botica')
        ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($initial)), date('Y-m-d 23:59:59', strtotime($final))])
        ->orderby('a.id','desc')
        ->get();

       // dd($visitas);




        return $visitas;
  }



  public function createView() {

    $profesionales =Profesional::where("estatus", '=', 1)->get();
    $boticas = Botica::where('estatus','=',1)->get();
    return view('visitas.create', compact('profesionales','boticas'));
  }

  public function create(Request $request){


    $visitas = new Visitas();
    if($request->id_profesional <> NULL){
    $visitas->id_profesional =$request->id_profesional;
    }else{
    $visitas->id_profesional =99;
    }
    if($request->id_botica <> NULL){
    $visitas->id_botica =$request->id_botica;
    }else{
    $visitas->id_botica =99;
    }
    $visitas->id_visitador = \Auth::user()->id;
    $visitas->save(); 

		Toastr::success('La Visita Fue Registrada.', 'Profesional Visitado!', ['progressBar' => true]);
       return redirect()->route('visitas.index');
	}   
}
