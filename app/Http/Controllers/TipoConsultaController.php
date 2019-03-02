<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TipoConsulta;
use DB;
use Toastr;
use Auth;

class TipoConsultaController extends Controller
{

	public function index(){


	$analisis = DB::table('tipo_consultas as a')
        ->select('a.id','a.detalle','a.precio','c.name as user','c.lastname')
		->join('users as c','c.id','a.usuario')
        ->orderby('a.id','desc')
        ->get();     
        return view('generics.index', [
        "icon" => "fa-list-alt",
        "model" => "tipo",
        "headers" => ["Detalle", "Precio al Pùblico","Registrado Por:", "Editar", "Eliminar"],
        "data" => $analisis,
        "fields" => [ "detalle", "precio", "user"],
          "actions" => [
            '<button type="button" class="btn btn-info">Transferir</button>',
            '<button type="button" class="btn btn-warning">Editar</button>'
          ]
      ]);  
	}



	public function create(Request $request){
        $validator = \Validator::make($request->all(), [
          'detalle' => 'required|string|max:255',
          'precio' => 'required|string|max:255',
         
        ]);
        if($validator->fails()) 
          return redirect()->action('TipoConsultaController@createView', ['errors' => $validator->errors()]);
		$tipo = TipoConsulta::create([
	      'detalle' => $request->detalle,
	      'precio' => $request->precio,
		  'usuario' => 	Auth::user()->id

   		]);
           
         	   
		
            Toastr::success('Registrado Exitosamente.', 'Tipo de Consulta!', ['progressBar' => true]);

		return redirect()->action('TipoConsultaController@index', ["created" => true, "tipo" => TipoConsulta::all()]);
	}    

  public function delete($id){
    $tipo = TipoConsulta::find($id);
    $tipo->delete();
    return redirect()->action('TipoConsultaController@index', ["deleted" => true, "tipo" => TipoConsulta::all()]);
  }

  public function createView() {

    return view('archivos.tipo.create');
  }

    public function editView($id){
      $p = TipoConsulta::find($id);
      return view('archivos.tipo.edit', ["detalle" => $p->detalle, "precio" => $p->precio,"id" => $p->id]);
    }

      public function edit(Request $request){
      $p = TipoConsulta::find($request->id);
      $p->detalle = $request->detalle;
      $p->precio = $request->precio;
      $res = $p->save();
      return redirect()->action('TipoConsultaController@index', ["edited" => $res]);
    }

  public function getTipo($id)
  {
    return TipoConsulta::findOrFail($id);
  }
}
