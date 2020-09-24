<?php

namespace App\Http\Controllers\Existencias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Existencias\{Producto, Existencia, Transferencia,Salidas,SalidasProductos};
use App\Models\Config\{Medida, Categoria, Sede, Proveedor};
use DB;
use App\Models\{Creditos, Ventas, Servicios,Pacientes,VentasProductos};
use App\Models\Pacientes\Paciente;
use Toastr;
use Carbon\Carbon;
use Auth;



class ProductoController extends Controller
{

    public function index(){
		//	$producto = Producto::all();
      $producto =Producto::where("sede_id", '=', \Session::get("sede"))->where("almacen",'=', 1)->orderBy('nombre','ASC')->get();
			return view('generics.index6', [
				"icon" => "fa-list-alt",
				"model" => "existencias",
        "model1" => "Productos en Almacen Central",
				"headers" => ["id", "Nombre","Medida", "Categoria","Cantidad","Precio Unidad","Precio Venta","Vencimiento","Editar","Eliminar"],
				"data" => $producto,
				"fields" => ["id", "nombre","medida", "categoria","cantidad","preciounidad","precioventa","vence"],
          "actions" => [
            '<button type="button" class="btn btn-info">Transferir</button>',
            '<button type="button" class="btn btn-warning">Editar</button>'
          ]
			]);    	
    }

      public function index2(){
    //  $producto = Producto::all();
      $producto =Producto::where("sede_id", '=', \Session::get("sede"))->where("almacen",'=', 2)->orderBy('nombre','ASC')->get();
      return view('generics.index5', [
        "icon" => "fa-list-alt",
        "model" => "existencias",
        "model1" => "Productos en Almacen Local",
        "headers" => ["id", "Nombre","Medida", "Categoria","Cantidad","Precio Unidad","Precio Venta","Vencimiento", "Eliminar"],
        "data" => $producto,
        "fields" => ["id", "nombre","medida", "categoria","cantidad","preciounidad","precioventa","vence"],
          "actions" => [
            '<button type="button" class="btn btn-info">Transferir</button>',
            '<button type="button" class="btn btn-warning">Editar</button>'
          ]
      ]);     
    }

    
   public function entrada(Request $request){
    
          $p = Producto::find($request->producto);
          $p->cantidad = $p->cantidad + $request->cantidadplus;
          $res = $p->save();
          Toastr::success('La Entrada se Registro Exitosamente.', 'Producto!', ['progressBar' => true]);
          return redirect()->action('Existencias\ProductoController@index', ["created" => false]);
  
    }

    public function createView($extraArgs = []){
    	return view('existencias.create', ["categorias" => Categoria::all(), "medidas" => Medida::all()] + $extraArgs);
    }

    public function editView($id){
      $p = Producto::find($id);
      return view('existencias.edit', ["medidas" => Medida::all(), "categorias" => Categoria::all(), "nombre" => $p->nombre, "cantidad" => $p->cantidad,"codigo" => $p->codigo, "vence" => $p->vence,"id" => $p->id,"preciounidad" => $p->preciounidad,"precioventa" => $p->precioventa]);
      
    }

   /* public function productInView(){
      return view('existencias.entrada', [
        "productos" => Producto::where('sede_id', '=', 1)->get(['id', 'nombre']),
        "sedes" => Sede::all(),
        "proveedores" => Proveedor::all()
      ]);
    }*/

     public function productInView(){
      $sedes = Sede::where("id",'=',1)->get(["id", "name"]);
      return view('existencias.entrada', ["productos" => Producto::where("sede_id", '=', \Session::get("sede"))->where("almacen",'=', 1)->get(['id', 'nombre']),"sedes" => $sedes,"proveedores" => Proveedor::all()]);    
    }

        public function salida_servicios(){
      $sedes = Sede::where("id",'=',1)->get(["id", "name"]);
      return view('existencias.salidaserv', ["productos" => Producto::where("sede_id", '=', \Session::get("sede"))->where("almacen",'=', 2)->get(['id', 'nombre']),"pacientes" => Pacientes::where('estatus','=',1)->get(), "servicios" => Servicios::where('estatus','=',1)->get()]);    
    }

    public function salidaservicio(Request $request){

              $salida = new Salidas();
              $salida->paciente = $request->paciente;
              $salida->servicio = $request->servicio;
              $salida->usuario = Auth::user()->id;
              $salida->sede = \Session::get("sede");
              $salida->save(); 

              if (isset($request->id_laboratorio)) {
                foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
                  if (!is_null($laboratorio['laboratorio'])) {

                  $searchProduct = DB::table('productos')
                    ->select('*')
                    ->where('id','=', $laboratorio['laboratorio'])
                    ->first();   

                   $cantidadactual = $searchProduct->cantidad;



                    $lab = new SalidasProductos();
                    $lab->id_producto =  $laboratorio['laboratorio'];
                    $lab->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                    $lab->id_salida = $salida->id;
                    $lab->save();

                    Producto::where('id', $laboratorio['laboratorio'])
                  ->update([
                      'cantidad' => $cantidadactual - $request->monto_abol['laboratorios'][$key]['abono'],
                  ]);



                  } 
                }
              } 

        Toastr::success('Registrada Exitosamente', 'Salida de Producto!', ['progressBar' => true]);
      return redirect()->action('Existencias\ProductoController@salida_servicios', ["created" => true]);

    }


    public function productOutView(){
      return view('existencias.salida', [
        "productos" => Producto::where("sede_id", '=', \Session::get("sede"))->where("almacen",'=', 2)->where("categoria",'<>',3)->orderby('nombre','asc')->get(['id', 'nombre','cantidad']),
        "sedes" => Sede::all(),
        "proveedores" => Proveedor::all(),"pacientes" => Paciente::where('estatus','=',1)->orderby('apellidos','asc')->get()
      ]);    
    }

    public function productTransView(){
      $sedes = Sede::whereNotIn("id", [\Session::get('sede')])->get(["id", "name"]);
      return view('existencias.transferir', ["productos" => Producto::where("sede_id", '=', \Session::get("sede"))->where("almacen",'=', 2)->get(['id', 'nombre']), "sedes" => $sedes]);    
    }

    public function getProduct($id){
     
      return Producto::findOrFail($id);

    }

    public function addCant(Request $request){


	
       $searchProduct = DB::table('productos')
                    ->select('*')
                    ->where('almacen','=','2')
                    ->where('id','=', $request->id_laboratorio['laboratorios'])
                    ->first();   

                    $nombre = $searchProduct->nombre;
					$cantidadactual = $searchProduct->cantidad;
		if( $request->cantidadplus > $cantidadactual){
		 Toastr::error('Cantidad excede Maximo en stock', 'Error!', ['progressBar' => true]);
		 return redirect()->action('Existencias\ProductoController@index2', ["created" => true]);
		} else {
			
		  

              $ventas = new Ventas();
              $ventas->id_usuario = Auth::user()->id;
              $ventas->save();  


            if (isset($request->id_laboratorio)) {
      foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
        if (!is_null($laboratorio['laboratorio'])) {


           $searchProduct = DB::table('productos')
                    ->select('*')
                    ->where('almacen','=','2')
                    ->where('id','=', $laboratorio['laboratorio'])
                    ->first();   

          $cantidadactual = $searchProduct->cantidad;
          $precio = $searchProduct->precioventa;

          if($request->monto_l['laboratorios'][$key]['monto'] == NULL){
            $preciov= $precio;
          } else {
            $preciov=$request->monto_l['laboratorios'][$key]['monto']; 
          }




          $lab = new VentasProductos();
          $lab->id_producto =  $laboratorio['laboratorio'];
          $lab->monto =  $preciov * $request->monto_abol['laboratorios'][$key]['abono'];
          $lab->cantidad = $request->monto_abol['laboratorios'][$key]['abono'];
          $lab->id_venta = $ventas->id;
          $lab->paciente =$request->paciente;
          $lab->id_usuario= Auth::user()->id;
          $lab->save();

          Producto::where('id', $laboratorio['laboratorio'])
                  ->update([
                      'cantidad' => $cantidadactual - $request->monto_abol['laboratorios'][$key]['abono'],
                  ]);

              $creditos = new Creditos();
              $creditos->origen = 'VENTA DE PRODUCTOS';
              $creditos->id_atencion = NULL;
              $creditos->monto= $precio * $request->monto_abol['laboratorios'][$key]['abono'];
              $creditos->id_sede = $request->session()->get('sede');
              $creditos->tipo_ingreso ='EF';
              $creditos->descripcion = 'VENTA DE PRODUCTOS';
              $creditos->id_venta= $lab->id;
              $creditos->id_usuario= Auth::user()->id;
              $creditos->save();

        } 
      }
    }
 
       Toastr::success('Registrada Exitosamente', 'Venta!', ['progressBar' => true]);
      return redirect()->action('Existencias\ProductoController@indexv', ["created" => true]);
		}
    
    }

    public function transfer(Request $request){
		
      $pfrom = Producto::where('sede_id', '=', \Session::get("sede"))
      ->where("id", '=', $request->id)
      ->get()->first();
      $pfrom->cantidad = $pfrom->cantidad - $request->cantidadplus;
      $wasSubs = $pfrom->save();

      $p = Producto::where('sede_id', '=', $request->sede)
      ->where("nombre", '=', $pfrom->nombre)
      ->get()->first();
      if($wasSubs){
        if($p){
          $p->cantidad = $p->cantidad + $request->cantidadplus;
          $res = $p->save();
          return response()->json(["success" => $res, "producto" => $pfrom, "to" => $p]);
        }else{
          $newprod = Producto::create([
            "nombre" => $pfrom->nombre,
            "categoria" => $pfrom->getOriginal("categoria"),
            "medida" => $pfrom->getOriginal("medida"),
            "vence" => $pfrom->getOriginal("vence"),
            "cantidad" => $request->cantidadplus,
            "sede_id" => $request->sede,
            "almacen" => 2
          ]);
          return response()->json(["success" => true, "producto" => $pfrom, "to" => $newprod]);
        }
      }
    }

    public function edit(Request $request){
      $p = Producto::find($request->id);
      $p->nombre = $request->nombre;
      $p->categoria = $request->categoria;
      $p->medida = $request->medida;
      //$p->cantidad = $request->cantidad;
	  $p->preciounidad = $request->preciounidad;
      $p->precioventa = $request->precioventa;
      $p->codigo = $request->codigo;
      $p->vence = $request->vence;
      $res = $p->save();

       $pl = Producto::where('padre','=',$request->id)->first();
      $pl->nombre = $request->nombre;
      $pl->categoria = $request->categoria;
      $pl->medida = $request->medida;
    $pl->preciounidad = $request->preciounidad;
      $pl->precioventa = $request->precioventa;
      $pl->codigo = $request->codigo;
      $pl->vence = $request->vence;
      $res = $pl->save();


      return redirect()->action('Existencias\ProductoController@index', ["edited" => $res]);
    }

    public function delete($id){
      $p = Producto::find($id);
      $res = $p->delete();
      
       Toastr::success('Eliminado Exitosamente.', 'Producto!', ['progressBar' => true]);
        return redirect()->action('Existencias\ProductoController@index2', ["created" => false]);
    }

    public function getExist($prod, $sede){
      $ex = Producto::where('id', '=', $prod)->where("sede_id", "=", $sede)->where("almacen",'=', 1)
      ->get(["cantidad"])->first();
      $prod = Producto::where('id', '=', $prod)->get()->first();
      if($ex){
        return response()->json(["existencia" => $ex, "exists" => true, "medida" => $prod->medida]);
      }else{
        return response()->json(["exists" => false, "medida" => $prod->medida]);
      }
    }


    public function codigoProduct(Request $request){

        $searchpacienteDNI = DB::table('productos')
                    ->select('*')
                   // ->where('estatus','=','1')
                    ->where('codigo','=', $request->codigo)
                    ->where('sede_id','=',$request->session()->get('sede'))
                    ->get();

           if (count($searchpacienteDNI) > 0){

              return true;
           } else {

              return false;
           }

    }

    public function create(Request $request){
      $validator = \Validator::make($request->all(), [
        'nombre' => 'required|unique:productos'
      ]);

        if($validator->fails()) {

          Toastr::error('Error Registrando.', 'Nombre de Producto ya EXISTE!', ['progressBar' => true]);
          return redirect()->action('Existencias\ProductoController@createView', ['errors' => $validator->errors()]);

      } else {
    

       $producto = Producto::create([
        "nombre" => $request->nombre,
        "codigo" => $request->codigo,
        "categoria" => $request->categoria,
        "medida" => $request->medida,
        "preciounidad" => $request->preciounidad,
        "precioventa" => $request->precioventa,
        "vence" => $request->vence,
        "sede_id" => $request->session()->get('sede'),
        "almacen" => 1
      ]);

       }
	  
	    
       Toastr::success('Registrado Exitosamente.', 'Producto!', ['progressBar' => true]);
       return redirect()->action('Existencias\ProductoController@index', ["created" => true]);
       
     


   }
   
		

    public function historicoView(){
      return view('existencias.historico', ["transferencias" => $this->unique_multidim_array(Transferencia::all(), "code")]);
    }

    public function transView($code){
      $t = Transferencia::where('code', '=', $code)->get();
      return view('existencias.transferencia', ["transferencias" => $t, "code" => $code]);
    }

       public function indexv(Request $request){

       if(! is_null($request->fecha)) {

    $f1 = $request->fecha;
    $f2 = $request->fecha2;    


               
             $atenciones = DB::table('ventas as a')
            ->select('a.id','a.id_usuario','v.id_producto','v.id_venta as id2','v.paciente','v.created_at','v.id as id3','v.monto','v.cantidad','e.name','e.lastname','p.nombres','p.apellidos')
            ->join('ventas_productos as v','v.id_venta','a.id')
            ->join('users as e','e.id','a.id_usuario')
            ->join('pacientes as p','p.id','v.paciente')
            ->groupBy('a.id')
            ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($f1)), date('Y-m-d 23:59:59', strtotime($f2))])
            ->orderby('a.id','desc')
            ->get();

           $aten = VentasProductos::whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($f1)), date('Y-m-d 23:59:59',                        strtotime($f2))])
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();

            if ($aten->monto == 0) {
        }
          
           $cantidad = VentasProductos::whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($f1)), date('Y-m-d 23:59:59',                        strtotime($f2))])
                        ->select(DB::raw('COUNT(DISTINCT id_venta) as cantidad'))
                       ->first();

        if ($cantidad->cantidad == 0) {
        }


        


        } else {


            $atenciones = DB::table('ventas as a')
            ->select(DB::raw('SUM(v.monto) as monto'),'a.id','a.id_usuario','v.id_producto','v.id_venta as id2','v.id as id3','v.paciente','v.created_at','v.monto','v.cantidad','e.name','e.lastname','p.nombres','p.apellidos')
            ->join('ventas_productos as v','v.id_venta','a.id')
            ->join('users as e','e.id','a.id_usuario')
            ->join('pacientes as p','p.id','v.paciente')
            ->groupBy('a.id')
            ->whereDate('a.created_at', '=',Carbon::today()->toDateString())
            ->orderby('a.id','desc')
            ->get();

       
           

        $aten = VentasProductos::whereDate('created_at', '=',Carbon::today()->toDateString())
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();
        if ($aten->monto == 0) {
        }

            $cantidad = VentasProductos::whereDate('created_at', '=',Carbon::today()->toDateString())
                        ->select(DB::raw('COUNT(DISTINCT id_venta) as cantidad'))
                       ->first();

        if ($cantidad->cantidad == 0) {
        }





        }

        $ventasp = new VentasProductos();
        $ventas = new Ventas();
        return view('existencias.ventas.index', ["atenciones" => $atenciones, "aten" => $aten,"cantidad" => $cantidad,"ventasp" => $ventasp,"ventas" => $ventas]);
  }


   public function ticket_ver_ventas($id) 
    {

      
          $ticket = DB::table('ventas as v')
            ->select('v.id','a.id_producto','a.id_venta','a.paciente','a.created_at','a.monto','a.cantidad','e.name','e.lastname','b.nombre','b.codigo','v.id_usuario','p.nombres','p.apellidos','p.dni')
            ->join('ventas_productos as a','a.id_venta','v.id')
            ->join('productos as b','b.id','a.id_producto')
            ->join('users as e','e.id','v.id_usuario')
            ->join('pacientes as p','p.id','a.paciente')
            ->where('v.id','=',$id)
            ->first();


          $productos = DB::table('ventas as v')
            ->select('v.id','a.id_producto','a.id_venta','a.cantidad','b.nombre','b.codigo','v.id_usuario')
            ->join('ventas_productos as a','a.id_venta','v.id')
            ->join('productos as b','b.id','a.id_producto')
            ->where('v.id','=',$id)
            ->get();


        $monto = VentasProductos::where('id_venta', '=',$id)
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();
        if ($monto->monto == 0) {
        }


        $view = \View::make('existencias.ventas.ticket')->with('ticket', $ticket)->with('productos', $productos)->with('monto', $monto);
        $pdf = \App::make('dompdf.wrapper');
       // $pdf->setPaper('A3');
        $pdf->setPaper(array(0,0,800.00,3000.00));
        $pdf->loadHTML($view);
        return $pdf->stream('ticket_ver_ventas');
    }


   public function delete_venta($id)
  {

     $venta = VentasProductos::where('id', '=',$id)->first();



     $productoventa=$venta->id_producto;
     $cantidadventa=$venta->cantidad;



    $producto = Producto::where('id', '=',$productoventa)
      ->get()->first();

    $cantactual=$producto->cantidad;



     Producto::where('id', $productoventa)
                  ->update([
                      'cantidad' => $cantactual + $cantidadventa,
                  ]);


    $venta = Ventas::where('id','=',$id)->delete();

    $ventaP = VentasProductos::where('id', '=',$id)->delete();

    $creditos = Creditos::where('id_venta','=',$id);
    $creditos->delete();

    Toastr::success('Eliminada Exitosamente', 'VENTA!', ['progressBar' => true]);
    return redirect()->action('Existencias\ProductoController@indexv', ["created" => false]);
  } 


    function unique_multidim_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
        return $temp_array; 
    }     
}
