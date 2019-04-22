<?php

namespace App\Http\Controllers\Archivos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Servicios;
use App\Models\Historiales;
use App\Models\ServicioMaterial;
use App\Models\Botica;
use App\User;
use Auth;
use Toastr;
use DB;

class BoticaController extends Controller
{

 public function index(){

      //$servicios =Servicios::where("estatus", '=', 1)->get();
	  $botica = DB::table('boticas as a')
        ->select('a.id','a.nombre','a.responsable','a.direccion','a.estatus','c.name','c.lastname')
		->join('users as c','c.id','a.usuario')
        ->where('a.estatus','=', 1)
        ->get();  
	  
      return view('archivos.botica.index', ['botica' => $botica]);  
    }



	public function create(Request $request){
       
          $botica = new Botica;
          $botica->nombre = $request->nombre;
          $botica->responsable  = $request->responsable;
          $botica->direccion  = $request->direccion;
          $botica->estatus  =1;
		  $botica->usuario = Auth::user()->id;
		  $botica->save();



		 $users= User::create([
        'name' => 'BOTICA',
        'lastname' => $request->nombre,
        'tipo' => '4',
        ]);



          return redirect()->action('Archivos\BoticaController@index', ["created" => true, "centros" => Botica::all()]);
          
  }

  public function delete($id){
    $servicios = Botica::find($id);
    $servicios->estatus=0;
    $servicios->save();
    return redirect()->action('Archivos\BoticaController@index', ["deleted" => true, "servicios" => Servicios::all()]);
  }

  public function createView() {
    return view('archivos.botica.create');
  }

   
     public function editView($id){
      $p = Botica::find($id);
      return view('archivos.botica.edit', ["nombre" => $p->nombre, "responsable" => $p->responsable,"direccion" => $p->direccion,"id" => $p->id,]);
      
    } 

       public function edit(Request $request){
      $p = Botica::find($request->id);
      $p->nombre = $request->nombre;
      $p->responsable = $request->responsable;
      $p->direccion = $request->direccion;
      $res = $p->save();
      return redirect()->action('Archivos\BoticaController@index', ["edited" => $res]);
    }

   


    
}
