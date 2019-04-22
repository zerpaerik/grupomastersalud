<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Atenciones;
use App\Models\Debitos;
use App\Models\Analisis;
use App\Models\Creditos;
use App\Models\Metodos;
use App\Models\VentasProductos;
use App\Models\ResultadosServicios;
use App\Models\ResultadosLaboratorios;
use App\Models\Events\Event;
use App\Models\Pacientes\Paciente;
use PDF;
use Auth;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Style\Font;
use HTMLtoOpenXML;
use File;

class ReportesController extends Controller

{

	 public function verResultado($id=void){
       
                $searchtipo = DB::table('atenciones as a')
                ->select('a.id','a.es_servicio','a.es_laboratorio','a.resultado')
                ->where('a.resultado','=',1)
                ->where('a.id','=', $id)
                ->first();
           
                $es_servicio = $searchtipo->es_servicio;
                $es_laboratorio = $searchtipo->es_laboratorio;


                if (!is_null($es_servicio)) {

                $resultado = DB::table('atenciones as a')
                ->select('a.id','a.id_paciente','a.origen_usuario','a.resultado','a.id_servicio','b.name as nompac','b.lastname as apepac','c.nombres','c.apellidos','c.dni','d.descripcion','e.detalle','a.created_at')
                ->join('users as b','b.id','a.origen_usuario')
                ->join('pacientes as c','c.id','a.id_paciente')
                ->join('resultados_servicios as d','d.id_atencion','a.id')
                ->join('servicios as e','e.id','a.id_servicio')
                ->where('a.resultado','=',1)
                ->where('a.id','=', $id)
                ->first();

                } else {

                $resultado = DB::table('atenciones as a')
                ->select('a.id','a.id_paciente','a.origen_usuario','a.resultado','a.id_laboratorio','b.name as nompac','b.lastname as apepac','c.nombres','c.apellidos','c.dni','d.descripcion','e.name as detalle','a.created_at')
                ->join('users as b','b.id','a.origen_usuario')
                ->join('pacientes as c','c.id','a.id_paciente')
                ->join('resultados_laboratorios as d','d.id_atencion','a.id')
                ->join('analises as e','e.id','a.id_laboratorio')
                ->where('a.resultado','=',1)
                ->where('a.id','=', $id)
                ->first();


                }

        if(!is_null($resultado)){
            return $resultado;
         }else{
            return false;
         }  

     }


    public function editar($id)
    {
        $resultados = ReportesController::verResultado($id);

        return view('resultadosguardados.editar', ["resultados" => $resultados]);
    }

    public function update($id,Request $request)
    {      
        $searchtipo = DB::table('atenciones as a')
        ->select('a.id','a.es_servicio','a.es_laboratorio','a.resultado')
        ->where('a.resultado','=',1)
        ->where('a.id','=', $id)
        ->first();
           
        $es_servicio = $searchtipo->es_servicio;
        $es_laboratorio = $searchtipo->es_laboratorio;

        if (!is_null($es_servicio)) {
            DB::table('resultados_servicios')
            ->where('id_atencion',$searchtipo->id)
            ->update(['descripcion' => $request->descripcion]);
            return back();

        }
        else{
            DB::table('resultados_laboratorios')
            ->where('id_atencion',$searchtipo->id)
            ->update(['descripcion' => $request->descripcion]);
            return back();
        }

    }



    public function resultados_ver($id) 
    {
        $resultados =ReportesController::verResultado($id);
        $view = \View::make('reportes.resultados_ver')->with('resultados', $resultados);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('resultados_ver');
    }
	
	
	 public function verTicket($id){
       
                $searchtipo = DB::table('atenciones')
                ->select('id','es_servicio','es_laboratorio')
                ->where('id','=', $id)
                ->first();
           
                $es_servicio = $searchtipo->es_servicio;
                $es_laboratorio = $searchtipo->es_laboratorio;
				
		
                if (!is_null($es_servicio)) {

                $ticket = DB::table('atenciones as a')
                ->select('a.id','a.id_paciente','a.origen_usuario','a.ticket','a.id_servicio','b.name as nompac','b.lastname as apepac','c.nombres','c.apellidos','c.dni','e.detalle','a.created_at','a.abono','a.pendiente','a.monto')
                ->join('users as b','b.id','a.origen_usuario')
                ->join('pacientes as c','c.id','a.id_paciente')
                ->join('servicios as e','e.id','a.id_servicio')
                ->where('a.id','=', $id)
                ->first();
				
			 

                } else {

                $ticket = DB::table('atenciones as a')
                ->select('a.id','a.id_paciente','a.origen_usuario','a.ticket','a.id_laboratorio','b.name as nompac','b.lastname as apepac','c.nombres','c.apellidos','c.dni','e.name as detalle','a.created_at','a.abono','a.pendiente','a.monto')
                ->join('users as b','b.id','a.origen_usuario')
                ->join('pacientes as c','c.id','a.id_paciente')
                ->join('analises as e','e.id','a.id_laboratorio')
                ->where('a.id','=', $id)
                ->first();


                }

        if(!is_null($ticket)){
            return $ticket;
         }else{
            return false;
         }  

     }
	
	 public function ticket_ver($id) 
    {
        $ticket =ReportesController::verTicket($id);
        $view = \View::make('reportes.ticket_atencion_ver')->with('ticket', $ticket);
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('A5', 'landscape');
		//$pdf->setPaper(array(0,0,360.00,360.00));
        $pdf->setPaper(array(0,0,800.00,3000.00));
        $pdf->loadHTML($view);
        return $pdf->stream('ticket_ver');
    }

    public function formDiario()
    {
        return view('reportes.form_diario');
    }

    public function formConsolidado()
    {
        return view('reportes.form_consolidado');
    }

    


    public function relacion_diario(Request $request)
    {
       /* $atenciones = Atenciones::where('id_sede','=', $request->session()->get('sede'))
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
									->whereNotIn('monto',[0,0.00,99999])
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(abono) as monto'))
                                    ->first();
        if ($atenciones->cantidad == 0) {
            $atenciones->monto = 0;
        }*/

        $atenciones = Creditos::where('origen', 'ATENCIONES')
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereNotIn('monto',[0,0.00,99999])
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();

        if ($atenciones->cantidad == 0) {
            $atenciones->monto = 0;
        }
		
	

        $consultas = Creditos::where('origen', 'CONSULTAS')
		                            ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($consultas->cantidad == 0) {
            $consultas->monto = 0;
        }

        $otros_servicios = Creditos::where('origen', 'OTROS INGRESOS')
		                            ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($otros_servicios->cantidad == 0) {
            $otros_servicios->monto = 0;
        }

        $cuentasXcobrar = Creditos::where('origen', 'CUENTAS POR COBRAR')
		                             ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($cuentasXcobrar->cantidad == 0) {
            $cuentasXcobrar->monto = 0;
        }


         $ventas = Creditos::where('origen', 'VENTA DE PRODUCTOS')
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($ventas->cantidad == 0) {
            $ventas->monto = 0;
        }

        $punziones = Creditos::where('origen', 'VENTA DE PUNZIONES')
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($punziones->cantidad == 0) {
            $punziones->monto = 0;
        }

        $egresos = Debitos::whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
		                    ->where('id_sede','=', $request->session()->get('sede'))
                            ->where('mostrar','=',NULL)
                            ->select(DB::raw('origen, descripcion, monto'))
                            ->get();

        $efectivo = Creditos::where('tipo_ingreso', 'EF')
		                    ->where('id_sede','=', $request->session()->get('sede'))
                            ->whereNotIn('monto',[0,0.00,99999])
                            ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                            ->select(DB::raw('SUM(monto) as monto'))
                            ->first();
        if (is_null($efectivo->monto)) {
            $efectivo->monto = 0;
        }

        $tarjeta = Creditos::where('tipo_ingreso', 'TJ')
		                    ->where('id_sede','=', $request->session()->get('sede'))
                            ->whereNotIn('monto',[0,0.00,99999])
                            ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                            ->select(DB::raw('SUM(monto) as monto'))
                            ->first();

        if (is_null($tarjeta->monto)) {
            $tarjeta->monto = 0;
        }

          $metodos = Creditos::where('origen', 'METODOS ANTICONCEPTIVOS')
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($metodos->cantidad == 0) {
            $metodos->monto = 0;
        }

        $totalIngresos = $atenciones->monto + $consultas->monto + $otros_servicios->monto + $cuentasXcobrar->monto + $ventas->monto + $punziones->monto + $metodos->monto;

        $totalEgresos = 0;

        foreach ($egresos as $egreso) {
            $totalEgresos += $egreso->monto;
        }


        $hoy=date('d-m-Y');

                $fecha= $request->fecha;


        $view = \View::make('reportes.diario', compact('atenciones', 'consultas','otros_servicios', 'cuentasXcobrar', 'egresos', 'tarjeta', 'efectivo', 'totalEgresos', 'totalIngresos','metodos','hoy','fecha','ventas','punziones'));

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
     
       
        return $pdf->stream('diario_'.$request->fecha.'.pdf');

    }


    public function verReciboProfesional($id){
       
         $reciboprofesional = DB::table('atenciones as a')
        ->select('a.id','a.id_paciente','a.created_at','a.origen_usuario','a.origen','a.porcentaje','a.id_servicio','es_laboratorio','a.pagado_com','a.id_laboratorio','a.es_servicio','a.es_laboratorio','a.recibo','a.monto','a.porcentaje','a.abono','b.nombres','b.apellidos','b.dni','c.detalle as servicio','d.name as laboratorio','e.name','e.lastname','d.name as laboratorio')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('servicios as c','c.id','a.id_servicio')
        ->join('analises as d','d.id','a.id_laboratorio')
        ->join('users as e','e.id','a.origen_usuario')
        ->where('a.pagado_com','=', 1)
        ->where('a.recibo','=', $id)
       // ->orderby('a.id','desc')
        ->get();

        if($reciboprofesional){
            return $reciboprofesional;
         }else{
            return false;
         }  

     }

     public function verReciboProfesional2($id){
       
         $reciboprofesional2 = DB::table('atenciones as a')
        ->select('a.id','a.id_paciente','a.origen_usuario','a.recibo','a.monto','a.porcentaje','a.abono','b.nombres','b.apellidos','e.name','e.lastname')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('users as e','e.id','a.origen_usuario')
        ->where('a.pagado_com','=', 1)
        ->where('a.recibo','=', $id)
        ->groupBy('a.recibo')
        ->get();

        if($reciboprofesional2){
            return $reciboprofesional2;
         }else{
            return false;
         }  

     }

     public function verTotalRecibo($id){


        $totalRecibo = Atenciones::where('recibo', $id)
                            ->select(DB::raw('SUM(porcentaje) as totalrecibo'))
                            ->get();
     
        if($totalRecibo){
            return $totalRecibo;
         }else{
            return false;
         }  

     }

      public function recibo_profesionales_ver($id) 
    {

    
       $reciboprofesional = ReportesController::verReciboProfesional($id);
       $reciboprofesional2 = ReportesController::verReciboProfesional2($id);
       $totalrecibo = ReportesController::verTotalRecibo($id);



      
       $view = \View::make('reportes.recibo_profesionales_ver')->with('reciboprofesional', $reciboprofesional)->with('reciboprofesional2', $reciboprofesional2)->with('totalrecibo', $totalrecibo);
       $pdf = \App::make('dompdf.wrapper');
       $pdf->loadHTML($view);
       return $pdf->stream('recibo_profesionales_ver');
    /* }else{
      return response()->json([false]);
     }*/
    }

      public function recibo_caja_ver(Request $request,$id) 
    {

    
      
      $caja = DB::table('cajas as  a')
        ->select('a.id','a.cierre_matutino','a.cierre_vespertino','a.created_at','a.fecha','a.balance','a.sede','a.usuario','b.name','b.lastname')
        ->join('users as b','b.id','a.usuario')
        ->where('a.id','=',$id)
        ->first();


        $fecha=$caja->created_at;
        $fechainic=date('Y-m-d H:i:s', strtotime($caja->fecha));
        $fechafin=$caja->fecha." 23:59:59";
   
        


        $atenciones = Creditos::where('origen', 'ATENCIONES')
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereNotIn('monto',[0,0.00,99999])
                                    //->whereBetween('created_at', [strtotime($fechainic),strtotime($fecha)])
                                    ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    //->where('created_at','<=',$fecha)
                                   // ->whereBetween('created_at', [$fecha, $fecha])
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
                           
                                

        if ($atenciones->cantidad == 0) {
            $atenciones->monto = 0;
        }

         $consultas = Creditos::where('origen', 'CONSULTAS')
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($consultas->cantidad == 0) {
            $consultas->monto = 0;
        }

        $otros_servicios = Creditos::where('origen', 'OTROS INGRESOS')
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($otros_servicios->cantidad == 0) {
            $otros_servicios->monto = 0;
        }

        $cuentasXcobrar = Creditos::where('origen', 'CUENTAS POR COBRAR')
                                     ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($cuentasXcobrar->cantidad == 0) {
            $cuentasXcobrar->monto = 0;
        }

         $metodos = Creditos::where('origen', 'METODOS ANTICONCEPTIVOS')
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($metodos->cantidad == 0) {
            $metodos->monto = 0;
        }

          $ventas = Creditos::where('origen', 'VENTA DE PRODUCTOS')
                                   ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($ventas->cantidad == 0) {
            $ventas->monto = 0;
        }

        $egresos = Debitos::whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                            ->where('id_sede','=', $request->session()->get('sede'))
                            ->select(DB::raw('origen, descripcion, monto'))
                            ->get();

        $efectivo = Creditos::where('tipo_ingreso', 'EF')
                            ->where('id_sede','=', $request->session()->get('sede'))
                            ->whereNotIn('monto',[0,0.00,99999])
                            ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                            ->select(DB::raw('SUM(monto) as monto'))
                            ->first();
        if (is_null($efectivo->monto)) {
            $efectivo->monto = 0;
        }

        $tarjeta = Creditos::where('tipo_ingreso', 'TJ')
                            ->where('id_sede','=', $request->session()->get('sede'))
                            ->whereNotIn('monto',[0,0.00,99999])
                            ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                            ->select(DB::raw('SUM(monto) as monto'))
                            ->first();

        if (is_null($tarjeta->monto)) {
            $tarjeta->monto = 0;
        }

         $totalEgresos = 0;

        foreach ($egresos as $egreso) {
            $totalEgresos += $egreso->monto;
        }
    
         $totalIngresos = $atenciones->monto + $consultas->monto + $otros_servicios->monto + $cuentasXcobrar->monto + $metodos->monto + $ventas->monto;

        
 


       
       $view = \View::make('reportes.cierre_caja_ver', compact('atenciones', 'consultas','otros_servicios', 'cuentasXcobrar','metodos','ventas','caja','egresos','efectivo','tarjeta','totalEgresos','totalIngresos'));
      
       //$view = \View::make('reportes.cierre_caja_ver')->with('caja', $caja);
       $pdf = \App::make('dompdf.wrapper');
       //$pdf->setPaper('A4', 'landscape');
       $pdf->loadHTML($view);
       return $pdf->stream('recibo_cierre_caja_ver');
    /* }else{
      return response()->json([false]);
     }*/
    }

     public function recibo_caja_verd(Request $request,$id) 
    {

    
      
      $caja = DB::table('cajas as  a')
        ->select('a.id','a.cierre_matutino','a.cierre_vespertino','a.created_at','a.fecha','a.balance','a.usuario','b.name','b.lastname')
        ->join('users as b','b.id','a.usuario')
        ->where('a.id','=',$id)
        ->first();


        $fecha=$caja->created_at;
        $fechainic=date('Y-m-d H:i:s', strtotime($caja->fecha));
        $fechafin=$caja->fecha." 23:59:59";
   
    

          $servicios = DB::table('atenciones as a')
        ->select('a.id','a.created_at','a.id_paciente','a.origen_usuario','a.origen','a.id_servicio','a.id_paquete','a.id_sede','a.id_laboratorio','a.es_servicio','a.monto','a.tipopago','a.porcentaje','a.abono','b.nombres','b.apellidos','c.detalle as servicio','e.name','e.lastname')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('servicios as c','c.id','a.id_servicio')
        ->join('users as e','e.id','a.origen_usuario')
        ->where('a.es_servicio','=', 1)
        ->whereRaw("a.created_at >= ? AND a.created_at <= ?", 
                                     array($fechainic, $fecha))
        ->where('a.id_sede','=', $request->session()->get('sede'))
        ->whereNotIn('a.monto',[0,0.00,99999])
        ->orderby('a.id','desc')
        ->get();

        $totalServicios = Atenciones::where('es_servicio',1)
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                     ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('SUM(abono) as abono'))
                                    ->first();


         $laboratorios = DB::table('atenciones as a')
        ->select('a.id','a.created_at','a.id_paciente','a.origen_usuario','a.origen','a.id_servicio','a.id_paquete','a.id_laboratorio','a.id_sede','a.es_laboratorio','a.monto','a.tipopago','a.porcentaje','a.abono','b.nombres','b.apellidos','c.name as laboratorio','e.name','e.lastname')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('analises as c','c.id','a.id_laboratorio')
        ->join('users as e','e.id','a.origen_usuario')
        ->where('a.es_laboratorio','=', 1)
        ->where('a.id_sede','=', $request->session()->get('sede'))
         ->whereRaw("a.created_at >= ? AND a.created_at <= ?", 
                                     array($fechainic, $fecha))
        ->whereNotIn('a.monto',[0,0.00])
        ->orderby('a.id','desc')
        ->get();

        $totalLaboratorios = Atenciones::where('es_laboratorio',1)
                                     ->where('id_sede','=', $request->session()->get('sede'))
                                     ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('SUM(abono) as abono'))
                                    ->first();

         $paquetes = DB::table('atenciones as a')
        ->select('a.id','a.created_at','a.id_paciente','a.origen_usuario','a.origen','a.id_servicio','a.id_paquete','a.id_laboratorio','a.id_sede','a.es_laboratorio','a.monto','a.tipopago','a.porcentaje','a.abono','b.nombres','b.apellidos','c.detalle as paquete','e.name','e.lastname')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('paquetes as c','c.id','a.id_paquete')
        ->join('users as e','e.id','a.origen_usuario')
        ->where('a.es_paquete','=', 1)
        ->where('a.id_sede','=', $request->session()->get('sede'))
        ->whereRaw("a.created_at >= ? AND a.created_at <= ?", 
                                     array($fechainic, $fecha))
        ->whereNotIn('a.monto',[0,0.00])
        ->orderby('a.id','desc')
        ->get();

        $totalpaquetes = Atenciones::where('es_paquete',1)
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('SUM(abono) as abono'))
                                    ->first();
       
         $consultas = DB::table('events as a')
        ->select('a.id','a.profesional','a.sede','a.paciente','a.monto','a.date','a.created_at','b.nombres','b.apellidos','c.name','c.lastname as apepro')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('personals as c','c.id','a.profesional')
        ->where('a.sede','=', $request->session()->get('sede'))
        ->whereRaw("a.created_at >= ? AND a.created_at <= ?", 
                                     array($fechainic, $fecha))
        ->orderby('a.id','desc')
        ->get();

       

        $totalconsultas = Event::whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->where('sede','=', $request->session()->get('sede'))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();


        $otrosingresos = DB::table('creditos as a')
        ->select('a.id','a.origen','a.descripcion','a.tipo_ingreso','a.monto','a.created_at','a.id_sede')
       ->where('a.id_sede','=', $request->session()->get('sede'))
        ->where('a.origen','=','OTROS INGRESOS')
         ->whereRaw("a.created_at >= ? AND a.created_at <= ?", 
                                     array($fechainic, $fecha))
        ->orderby('a.id','desc')
        ->get();

        $totalotrosingresos = Creditos::where('origen','OTROS INGRESOS')
                                     ->where('id_sede','=', $request->session()->get('sede'))
                                     ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();

        $cuentasporcobrar = DB::table('creditos as a')
        ->select('a.id','a.origen','a.descripcion','a.tipo_ingreso','a.monto','a.created_at','a.id_atencion','b.id_paciente','b.id_servicio','b.id_laboratorio','b.id_paquete','b.es_servicio','b.es_laboratorio','b.es_paquete','c.nombres','c.apellidos','s.detalle as servicio','l.name as laboratorio','p.detalle as paquete','a.id_sede')
        ->join('atenciones as b','b.id','a.id_atencion')
        ->join('pacientes as c','c.id','b.id_paciente')
        ->join('servicios as s','s.id','b.id_servicio')
        ->join('analises as l','l.id','b.id_laboratorio')
        ->join('paquetes as p','p.id','b.id_paquete')
        ->where('a.origen','=','CUENTAS POR COBRAR')
        ->where('a.id_sede','=', $request->session()->get('sede'))
         ->whereRaw("a.created_at >= ? AND a.created_at <= ?", 
                                     array($fechainic, $fecha))
        ->orderby('a.id','desc')
        ->get();

        $totalcuentasporcobrar = Creditos::where('origen','CUENTAS POR COBRAR')
                                     ->where('id_sede','=', $request->session()->get('sede'))
                                     ->whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();
        $metodos = DB::table('metodos as a')
        ->select('a.id','a.id_paciente','a.id_producto','a.monto','a.sede','a.created_at','b.nombres','b.apellidos','c.nombre as producto')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('productos as c','c.id','a.id_producto')
        ->where('a.sede','=', $request->session()->get('sede'))
       ->whereRaw("a.created_at >= ? AND a.created_at <= ?", 
                                     array($fechainic, $fecha))
        ->orderby('a.id','desc')
        ->get();


       

        $totalmetodos = Metodos::whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                ->where('sede','=', $request->session()->get('sede'))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();

        $ventas = DB::table('ventas_productos as a')
        ->select('a.id','a.paciente','a.id_producto','a.id_venta','a.monto','a.cantidad','a.created_at','b.nombres','b.apellidos','c.nombre as producto')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('productos as c','c.id','a.id_producto')
       ->whereRaw("a.created_at >= ? AND a.created_at <= ?", 
                                     array($fechainic, $fecha))
        ->orderby('a.id','desc')
        ->get();


       

        $totalventas = VentasProductos::whereRaw("created_at >= ? AND created_at <= ?", 
                                     array($fechainic, $fecha))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();
    
     
 

        $view = \View::make('reportes.cierre_caja_verd', compact('servicios', 'totalServicios','laboratorios', 'totalLaboratorios', 'consultas', 'totalconsultas','otrosingresos','totalotrosingresos','cuentasporcobrar','totalcuentasporcobrar','paquetes','totalpaquetes','caja','metodos','totalmetodos','ventas','totalventas'));
      
       //$view = \View::make('reportes.cierre_caja_ver')->with('caja', $caja);
       $pdf = \App::make('dompdf.wrapper');
       //$pdf->setPaper('A4', 'landscape');
       $pdf->loadHTML($view);
       return $pdf->stream('recibo_cierre_caja_ver_detallado');
    /* }else{
      return response()->json([false]);
     }*/
    }

     public function recibo_caja_ver2(Request $request,$id,$fecha1=NULL,$fecha2=NULL) 
    {

     $cajamañana=DB::table('cajas as  a')
        ->select('a.id','a.cierre_matutino','a.cierre_vespertino','a.created_at','a.fecha','a.balance','a.sede','a.usuario','b.name','b.lastname')
        ->join('users as b','b.id','a.usuario')
        ->whereDate('fecha','=',Carbon::today()->toDateString())
        ->first();  

      $fechamañana=$cajamañana->created_at;   
    
      
      $caja = DB::table('cajas as  a')
        ->select('a.id','a.cierre_matutino','a.cierre_vespertino','a.created_at','a.fecha','a.balance','a.sede','a.usuario','b.name','b.lastname')
        ->join('users as b','b.id','a.usuario')
        ->where('a.id','=',$id)
        ->first();

        $fecha=$caja->created_at;


           

  
      //  $ver=Carbon::toDateTimeString($caja->created_at);

        $atenciones = Creditos::where('origen', 'ATENCIONES')
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereNotIn('monto',[0,0.00,99999])
                                    //->whereBetween('created_at', [strtotime($fechainic),strtotime($fecha)])
                                    ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    //->where('created_at','>',Carbon::toDateTimeString($caja->created_at))
                                 //   ->whereBetween('created_at', ['2019-01-20 11','2019-01-20 23'])
                                    //->where('created_at','>=',$fecha)
                                    //->whereTime('created_at', '>=', $fecha)
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
             


        if ($atenciones->cantidad == 0) {
            $atenciones->monto = 0;
        }

         $consultas = Creditos::where('origen', 'CONSULTAS')
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                      ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($consultas->cantidad == 0) {
            $consultas->monto = 0;
        }

        $otros_servicios = Creditos::where('origen', 'OTROS INGRESOS')
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                      ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($otros_servicios->cantidad == 0) {
            $otros_servicios->monto = 0;
        }

        $ventas = Creditos::where('origen', 'VENTA DE PRODUCTOS')
                                   ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($ventas->cantidad == 0) {
            $ventas->monto = 0;
        }


        $cuentasXcobrar = Creditos::where('origen', 'CUENTAS POR COBRAR')
                                     ->where('id_sede','=', $request->session()->get('sede'))
                                       ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($cuentasXcobrar->cantidad == 0) {
            $cuentasXcobrar->monto = 0;
        }

         $metodos = Creditos::where('origen', 'METODOS ANTICONCEPTIVOS')
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
                                    ->first();
        if ($metodos->cantidad == 0) {
            $metodos->monto = 0;
        }


        $egresos = Debitos::whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                            ->where('id_sede','=', $request->session()->get('sede'))
                            ->select(DB::raw('origen, descripcion, monto'))
                            ->get();

        $efectivo = Creditos::where('tipo_ingreso', 'EF')
                            ->where('id_sede','=', $request->session()->get('sede'))
                            ->whereNotIn('monto',[0,0.00,99999])
                            ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                            ->select(DB::raw('SUM(monto) as monto'))
                            ->first();
        if (is_null($efectivo->monto)) {
            $efectivo->monto = 0;
        }

        $tarjeta = Creditos::where('tipo_ingreso', 'TJ')
                            ->where('id_sede','=', $request->session()->get('sede'))
                            ->whereNotIn('monto',[0,0.00,99999])
                            ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                            ->select(DB::raw('SUM(monto) as monto'))
                            ->first();

        if (is_null($tarjeta->monto)) {
            $tarjeta->monto = 0;
        }

         $totalEgresos = 0;

        foreach ($egresos as $egreso) {
            $totalEgresos += $egreso->monto;
        }
    
         $totalIngresos = $atenciones->monto + $consultas->monto + $otros_servicios->monto + $cuentasXcobrar->monto + $metodos->monto + $ventas->monto;

    

        
 

       // $fecha = $caja->fecha;

       
       $view = \View::make('reportes.cierre_caja_ver', compact('atenciones', 'consultas','otros_servicios', 'cuentasXcobrar','metodos','caja','egresos','totalEgresos','totalIngresos','efectivo','tarjeta','ventas'));
      
       //$view = \View::make('reportes.cierre_caja_ver')->with('caja', $caja);
       $pdf = \App::make('dompdf.wrapper');
       //$pdf->setPaper('A4', 'landscape');
       $pdf->loadHTML($view);
       $pdf->setPaper(array(0,0,800.00,3000.00));
       return $pdf->stream('recibo_cierre_caja_ver');
    /* }else{
     }*/
    }

    public function recibo_caja_ver2d(Request $request,$id,$fecha1=NULL,$fecha2=NULL) 
    {
      

  if(!is_null($request->fecha1)){



      $cajamañana=DB::table('cajas as  a')
        ->select('a.id','a.cierre_matutino','a.cierre_vespertino','a.created_at','a.fecha','a.balance','a.sede','a.usuario','b.name','b.lastname')
        ->join('users as b','b.id','a.usuario')
        ->where('a.sede','=',$request->session()->get('sede'))
        ->whereDate('fecha','=',$request->fecha1)
        ->first();  

      $fechamañana=$cajamañana->created_at; 

       

    } else {

        $cajamañana=DB::table('cajas as  a')
        ->select('a.id','a.cierre_matutino','a.cierre_vespertino','a.created_at','a.fecha','a.balance','a.sede','a.usuario','b.name','b.lastname')
        ->join('users as b','b.id','a.usuario')
        ->where('a.sede','=',$request->session()->get('sede'))
        ->whereDate('fecha','=',Carbon::today()->toDateString())
        ->first();  

      $fechamañana=$cajamañana->created_at;   


    }

      $caja = DB::table('cajas as  a')
        ->select('a.id','a.cierre_matutino','a.cierre_vespertino','a.created_at','a.fecha','a.balance','a.sede','a.usuario','b.name','b.lastname')
        ->join('users as b','b.id','a.usuario')
        ->where('a.id','=',$id)
        ->first();

        $fecha=$caja->created_at;


        
       //
           $servicios = DB::table('atenciones as a')
        ->select('a.id','a.created_at','a.id_paciente','a.origen_usuario','a.origen','a.id_servicio','a.id_paquete','a.id_laboratorio','a.es_servicio','a.monto','a.tipopago','a.porcentaje','a.abono','b.nombres','b.apellidos','c.detalle as servicio','e.name','e.lastname','a.id_sede')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('servicios as c','c.id','a.id_servicio')
        ->join('users as e','e.id','a.origen_usuario')
        ->where('a.es_servicio','=', 1)
        ->where('a.id_sede','=', $request->session()->get('sede'))
        ->whereRaw("a.created_at > ? AND a.created_at <= ?", 
                                     array($fechamañana, $fecha))
        ->whereNotIn('a.monto',[0,0.00,99999])
        ->orderby('a.id','desc')
        ->get();

        $totalServicios = Atenciones::where('es_servicio',1)
                ->where('id_sede','=', $request->session()->get('sede'))
                                     ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('SUM(abono) as abono'))
                                    ->first();

         $laboratorios = DB::table('atenciones as a')
        ->select('a.id','a.created_at','a.id_paciente','a.origen_usuario','a.origen','a.id_servicio','a.id_paquete','a.id_laboratorio','a.es_laboratorio','a.monto','a.tipopago','a.porcentaje','a.abono','b.nombres','b.apellidos','c.name as laboratorio','e.name','e.lastname','a.id_sede')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('analises as c','c.id','a.id_laboratorio')
        ->join('users as e','e.id','a.origen_usuario')
        ->where('a.es_laboratorio','=', 1)
        ->where('a.id_sede','=', $request->session()->get('sede'))
         ->whereRaw("a.created_at > ? AND a.created_at <= ?", 
                                     array($fechamañana, $fecha))
        ->whereNotIn('a.monto',[0,0.00])
        ->orderby('a.id','desc')
        ->get();

        $totalLaboratorios = Atenciones::where('es_laboratorio',1)
                ->where('id_sede','=', $request->session()->get('sede'))
                                     ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('SUM(abono) as abono'))
                                    ->first();

         $paquetes = DB::table('atenciones as a')
        ->select('a.id','a.created_at','a.id_paciente','a.origen_usuario','a.origen','a.id_servicio','a.id_paquete','a.id_laboratorio','a.es_laboratorio','a.monto','a.tipopago','a.porcentaje','a.abono','b.nombres','b.apellidos','c.detalle as paquete','e.name','e.lastname','a.id_sede')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('paquetes as c','c.id','a.id_paquete')
        ->join('users as e','e.id','a.origen_usuario')
        ->where('a.es_paquete','=', 1)
                ->where('a.id_sede','=', $request->session()->get('sede'))
        ->whereRaw("a.created_at > ? AND a.created_at <= ?", 
                                     array($fechamañana, $fecha))
        ->whereNotIn('a.monto',[0,0.00])
        ->orderby('a.id','desc')
        ->get();

        $totalpaquetes = Atenciones::where('es_paquete',1)
                ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('SUM(abono) as abono'))
                                    ->first();
       
         $consultas = DB::table('events as a')
        ->select('a.id','a.profesional','a.paciente','a.monto','a.sede','a.date','a.created_at','b.nombres','b.apellidos','c.name','c.lastname as apepro')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('personals as c','c.id','a.profesional')
        ->where('a.sede','=', $request->session()->get('sede'))
        ->whereRaw("a.created_at > ? AND a.created_at <= ?", 
                                     array($fechamañana, $fecha))
        ->orderby('a.id','desc')
        ->get();


       

        $totalconsultas = Event::whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                ->where('sede','=', $request->session()->get('sede'))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();

        $metodos = DB::table('metodos as a')
        ->select('a.id','a.id_paciente','a.id_producto','a.monto','a.sede','a.created_at','b.nombres','b.apellidos','c.nombre as producto')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('productos as c','c.id','a.id_producto')
        ->where('a.sede','=', $request->session()->get('sede'))
        ->whereRaw("a.created_at > ? AND a.created_at <= ?", 
                                     array($fechamañana, $fecha))
        ->orderby('a.id','desc')
        ->get();


       

        $totalmetodos = Metodos::whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                ->where('sede','=', $request->session()->get('sede'))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();

        $otrosingresos = DB::table('creditos as a')
        ->select('a.id','a.origen','a.descripcion','a.id_sede','a.tipo_ingreso','a.monto','a.created_at')
        ->where('a.origen','=','OTROS INGRESOS')
        ->where('a.id_sede','=', $request->session()->get('sede'))
         ->whereRaw("a.created_at > ? AND a.created_at <= ?", 
                                     array($fechamañana, $fecha))
        ->orderby('a.id','desc')
        ->get();

        $totalotrosingresos = Creditos::where('origen','OTROS INGRESOS')
                ->where('id_sede','=', $request->session()->get('sede'))
                                     ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();

        $cuentasporcobrar = DB::table('creditos as a')
        ->select('a.id','a.origen','a.descripcion','a.tipo_ingreso','a.monto','a.created_at','a.id_atencion','b.id_paciente','b.id_servicio','b.id_laboratorio','b.id_paquete','b.es_servicio','b.es_laboratorio','b.es_paquete','c.nombres','c.apellidos','s.detalle as servicio','l.name as laboratorio','p.detalle as paquete','a.id_sede')
        ->join('atenciones as b','b.id','a.id_atencion')
        ->join('pacientes as c','c.id','b.id_paciente')
        ->join('servicios as s','s.id','b.id_servicio')
        ->join('analises as l','l.id','b.id_laboratorio')
        ->join('paquetes as p','p.id','b.id_paquete')
        ->where('a.origen','=','CUENTAS POR COBRAR')
        ->where('a.id_sede','=', $request->session()->get('sede'))
        ->whereRaw("a.created_at > ? AND a.created_at <= ?", 
                                     array($fechamañana, $fecha))
        ->orderby('a.id','desc')
        ->get();

        $totalcuentasporcobrar = Creditos::where('origen','CUENTAS POR COBRAR')
                ->where('id_sede','=', $request->session()->get('sede'))
                                     ->whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();
    
        
    
       
        $ventas = DB::table('ventas_productos as a')
        ->select('a.id','a.paciente','a.id_producto','a.id_venta','a.monto','a.cantidad','a.created_at','b.nombres','b.apellidos','c.nombre as producto')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('productos as c','c.id','a.id_producto')
      ->whereRaw("a.created_at > ? AND a.created_at <= ?", 
                                     array($fechamañana, $fecha))
        ->orderby('a.id','desc')
        ->get();


       

        $totalventas = VentasProductos::whereRaw("created_at > ? AND created_at <= ?", 
                                     array($fechamañana, $fecha))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();
    

       

        $view = \View::make('reportes.cierre_caja_verd', compact('servicios', 'totalServicios','laboratorios', 'totalLaboratorios', 'consultas', 'totalconsultas','otrosingresos','totalotrosingresos','cuentasporcobrar','totalcuentasporcobrar','paquetes','totalpaquetes','caja','metodos','totalmetodos','ventas','totalventas'));


      
       //$view = \View::make('reportes.cierre_caja_ver')->with('caja', $caja);
       $pdf = \App::make('dompdf.wrapper');
       //$pdf->setPaper('A4', 'landscape');
       $pdf->loadHTML($view);
       return $pdf->stream('recibo_cierre_caja_ver_detallado');
    /* }else{
     }*/
    }


     public function recibo_gasto_ver(Request $request,$id) 
    {

  
     $gastos = DB::table('debitos as a')
      ->select('a.id','a.descripcion','a.monto','a.nombre','a.created_at','a.id_sede')
      ->where('a.id','=',$id)
      ->first();
       
       $view = \View::make('reportes.gastos_ver', compact('gastos'));
      
       //$view = \View::make('reportes.cierre_caja_ver')->with('caja', $caja);
       $pdf = \App::make('dompdf.wrapper');
       //$pdf->setPaper('A5', 'landscape');
       $pdf->setPaper(array(0,0,800.00,3000.00));
       $pdf->loadHTML($view);
       return $pdf->stream('recibo_gastos_ver');
    /* }else{
     }*/
    }


    public function general_ingresos(Reques $request){


     $otrosingresos = DB::table('creditos as a')
        ->select('a.id','a.origen','a.descripcion','a.tipo_ingreso','a.id_sede','a.monto','a.created_at')
        ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
        ->where('a.id_sede','=', $request->session()->get('sede'))
        ->orderby('a.id','desc')
        ->get();








    }

    public function modelo_informe($id,$informe)
    {
        File::delete(File::glob('*.docx'));
        $informe = $templateProcessor = new TemplateProcessor(public_path('modelos_informes/'.$informe));
        $resultados = ReportesController::elasticSearch($id);
        $informe->setValue('name', $resultados->nombrePaciente. ' '.$resultados->apellidoPaciente);
        $informe->setValue('descripcion',$resultados->servicio);
        $informe->setValue('indicacion',$resultados->resultado);
        $informe->setValue('date',$resultados->created_at);
        $informe->saveAs($resultados->nombrePaciente.'-'.$resultados->apellidoPaciente.'-'.$resultados->dni.'.docx');
        return response()->download($resultados->nombrePaciente.'-'.$resultados->apellidoPaciente.'-'.$resultados->dni.'.docx');

    }

    public function relacion_detallado(Request $request)
    {

        $servicios = DB::table('atenciones as a')
        ->select('a.id','a.created_at','a.id_paciente','a.origen_usuario','a.origen','a.id_servicio','a.id_paquete','a.id_laboratorio','a.es_servicio','a.monto','a.tipopago','a.porcentaje','a.abono','a.id_sede','b.nombres','b.apellidos','c.detalle as servicio','e.name','e.lastname')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('servicios as c','c.id','a.id_servicio')
        ->join('users as e','e.id','a.origen_usuario')
        ->where('a.es_servicio','=', 1)
        ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
        ->where('a.id_sede','=', $request->session()->get('sede'))
         ->whereNotIn('a.monto',[0,0.00,99999])
        ->orderby('a.id','desc')
        ->get();

        $totalServicios = Atenciones::where('es_servicio',1)
		                            ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereNotIn('monto',[0,0.00,99999])
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('SUM(abono) as abono'))
                                    ->first();

         $laboratorios = DB::table('atenciones as a')
        ->select('a.id','a.created_at','a.id_paciente','a.origen_usuario','a.origen','a.id_servicio','a.id_paquete','a.id_laboratorio','a.es_laboratorio','a.monto','a.tipopago','a.porcentaje','a.abono','a.id_sede','b.nombres','b.apellidos','c.name as laboratorio','e.name','e.lastname')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('analises as c','c.id','a.id_laboratorio')
        ->join('users as e','e.id','a.origen_usuario')
		->where('a.id_sede','=', $request->session()->get('sede'))
        ->where('a.es_laboratorio','=', 1)
        ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
        ->where('a.id_sede','=', $request->session()->get('sede'))
         ->whereNotIn('a.monto',[0,0.00,99999])
        ->orderby('a.id','desc')
        ->get();

        $totalLaboratorios = Atenciones::where('es_laboratorio',1)
                                    ->whereNotIn('monto',[0,0.00,99999])
		                            ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('SUM(abono) as abono'))
                                    ->first();
		 $paquetes = DB::table('atenciones as a')
        ->select('a.id','a.created_at','a.id_paciente','a.origen_usuario','a.origen','a.id_servicio','a.id_paquete','a.id_laboratorio','a.es_laboratorio','a.monto','a.tipopago','a.porcentaje','a.abono','a.id_sede','b.nombres','b.apellidos','c.detalle as paquete','e.name','e.lastname')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('paquetes as c','c.id','a.id_paquete')
        ->join('users as e','e.id','a.origen_usuario')
		->where('a.id_sede','=', $request->session()->get('sede'))
        ->where('a.es_paquete','=', 1)
        ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
        ->where('a.id_sede','=', $request->session()->get('sede'))
        ->whereNotIn('a.monto',[0,0.00,99999])
        ->orderby('a.id','desc')
        ->get();

        $totalPaquetes = Atenciones::where('es_paquete',1)
                                     ->whereNotIn('monto',[0,0.00,99999])
		                            ->where('id_sede','=', $request->session()->get('sede'))
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('SUM(abono) as abono'))
                                    ->first();						
       
         $consultas = DB::table('events as a')
        ->select('a.id','a.profesional','a.paciente','a.sede','a.monto','a.created_at','b.nombres','b.apellidos','c.name','c.lastname as apepro')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('personals as c','c.id','a.profesional')
        ->where('a.sede','=', $request->session()->get('sede'))
        ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
        ->orderby('a.id','desc')
        ->get();
        

        $totalconsultas = Event::where('sede','=', $request->session()->get('sede'))
                                  ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('                 Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();

        $otrosingresos = DB::table('creditos as a')
        ->select('a.id','a.origen','a.descripcion','a.tipo_ingreso','a.id_sede','a.monto','a.created_at')
        ->where('a.origen','=','OTROS INGRESOS')
        ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
        ->where('a.id_sede','=', $request->session()->get('sede'))
        ->orderby('a.id','desc')
        ->get();

        $totalotrosingresos = Creditos::where('origen','OTROS INGRESOS')
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('                 Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();

        $cuentasporcobrar = DB::table('creditos as a')
        ->select('a.id','a.origen','a.descripcion','a.tipo_ingreso','a.id_sede','a.monto','a.created_at')
        ->where('a.origen','=','CUENTAS POR COBRAR')
        ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
        ->where('a.id_sede','=', $request->session()->get('sede'))
        ->orderby('a.id','desc')
        ->get();

        $totalcuentasporcobrar = Creditos::where('origen','CUENTAS POR COBRAR')
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('                 Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();

          $metodos = DB::table('metodos as a')
        ->select('a.id','a.id_paciente','a.id_usuario','a.monto','a.proximo','a.created_at','a.id_producto','c.name','c.lastname','b.nombres','b.apellidos','b.dni','d.nombre as producto')
        ->join('users as c','c.id','a.id_usuario')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('productos as d','d.id','a.id_producto')
        ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
        ->orderBy('a.created_at','desc')
        ->get(); 


        $totalmetodos = Creditos::where('origen','METODOS ANTICONCEPTIVOS')
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();


       $ventas = DB::table('ventas_productos as a')
        ->select('a.id','a.id_producto','a.cantidad','a.paciente','a.monto','b.nombre','c.nombres','c.apellidos','a.created_at')
        ->join('productos as b','b.id','a.id_producto')
        ->join('pacientes as c','c.id','a.paciente')
        ->whereBetween('a.created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('Y-m-d 23:59:59', strtotime($request->fecha))])
        ->orderby('a.id','desc')
        ->get();

        $totalventas = Creditos::where('origen','VENTA DE PRODUCTOS')
                                    ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($request->fecha)), date('                 Y-m-d 23:59:59', strtotime($request->fecha))])
                                    ->where('id_sede','=', $request->session()->get('sede'))
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();


    
    
     
        $hoy=date('d-m-Y');
       
        $view = \View::make('reportes.detallado', compact('servicios', 'totalServicios','laboratorios', 'totalLaboratorios', 'consultas', 'totalconsultas','otrosingresos','totalotrosingresos','cuentasporcobrar','totalcuentasporcobrar','paquetes','totalPaquetes','metodos','totalmetodos','ventas','totalventas','hoy'));

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
     
       
        return $pdf->stream('detallado'.$request->fecha.'.pdf');

    }

    private function elasticSearch($id){
        
        $resultados = DB::table('atenciones as a')
        ->select('a.id','a.id_paciente','a.origen_usuario','a.es_servicio','a.es_laboratorio','a.created_at','a.origen','a.id_servicio','a.pendiente','a.id_laboratorio','a.monto','a.porcentaje','a.informe','a.abono','a.resultado','b.nombres as nombrePaciente','b.apellidos as apellidoPaciente','c.detalle as servicio','e.name','e.lastname','d.name as laboratorio','b.dni')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('servicios as c','c.id','a.id_servicio')
        ->join('analises as d','d.id','a.id_laboratorio')
        ->join('users as e','e.id','a.origen_usuario')
        ->whereNotIn('a.monto',[0,0.00])
        ->where('a.resultado','=', NULL)
        ->where('a.id','=',$id)
        ->first();

        return $resultados;
    }

     public function historialp(Request $request)
    {
         $atenciones = DB::table('atenciones as a')
    ->select('a.id','a.created_at','a.id_paciente','a.origen_usuario','a.origen','a.id_servicio','a.id_paquete','a.id_laboratorio','a.es_servicio','a.es_laboratorio','a.es_paquete','a.monto','a.porcentaje','a.abono','a.id_sede','b.nombres','b.apellidos','b.dni','c.detalle as servicio','e.name','e.lastname','h.name as user','h.lastname as userp','d.name as laboratorio','f.detalle as paquete','cr.tipo_ingreso')
    ->join('pacientes as b','b.id','a.id_paciente')
    ->join('servicios as c','c.id','a.id_servicio')
    ->join('analises as d','d.id','a.id_laboratorio')
    ->join('users as e','e.id','a.origen_usuario')
    ->join('users as h','h.id','a.usuario')
    ->join('paquetes as f','f.id','a.id_paquete')
    ->join('creditos as cr','cr.id_atencion','a.id')
    ->whereNotIn('a.monto',[0,0.00,99999])
    ->where('a.id_sede','=', $request->session()->get('sede'))
    ->where('b.dni','=',$request->paciente)
    ->orderby('a.id','desc')
    ->get();

    $event = DB::table('events as e')
    ->select('e.id as EventId','e.paciente','e.created_at','e.atendido','e.title','e.sede','e.monto','e.profesional','e.date','e.time','p.dni','p.direccion','p.telefono','p.fechanac','p.gradoinstruccion','p.ocupacion','p.nombres','p.apellidos','p.id as pacienteId','per.name as nombrePro','per.lastname as apellidoPro','per.id as profesionalId','rg.start_time','rg.end_time','rg.id')
    ->join('pacientes as p','p.id','=','e.paciente')
    ->join('personals as per','per.id','=','e.profesional')
    ->join('rangoconsultas as rg','rg.id','=','e.time')
    ->where('p.dni','=',$request->paciente)
    ->get();

     $metodos = DB::table('metodos as a')
        ->select('a.id','a.id_paciente','a.id_usuario','a.monto','a.proximo','a.sede','a.created_at','a.id_producto','c.name','c.lastname','b.nombres','b.apellidos','b.dni','b.telefono','b.dni','d.nombre as producto')
        ->join('users as c','c.id','a.id_usuario')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->join('productos as d','d.id','a.id_producto')
        ->where('b.dni','=',$request->paciente)
        ->orderBy('a.created_at','asc')
        ->get(); 

          $pacientes = DB::table('pacientes as a')
        ->select('*')
        ->where('estatus','=',1)
        ->orderBy('nombres','asc')
        ->get(); 

      // $pacientes =Pacientes::where("estatus", '=', 1)->orderby('nombres','asc')->get();

        return view('reportes.historial.pacientes',["pacientes" => $pacientes,"atenciones" => $atenciones,"event" => $event,"metodos" => $metodos]);
    }

      public function recibo_cobro_ver($id)
  { 
        $recibo = DB::table('historialcobros as a')
        ->select('a.id','a.id_atencion','a.id_paciente','a.monto','a.abono_parcial','a.abono','a.pendiente','b.nombres','b.apellidos','b.dni','a.created_at','a.updated_at')
        ->join('pacientes as b','b.id','a.id_paciente')
        ->where('a.id','=',$id)
        ->first();




       $view = \View::make('reportes.recibocobro', compact('recibo'));
      
       //$view = \View::make('reportes.cierre_caja_ver')->with('caja', $caja);
       $pdf = \App::make('dompdf.wrapper');
       //$pdf->setPaper('A5', 'landscape');
       $pdf->setPaper(array(0,0,800.00,3000.00));
       $pdf->loadHTML($view);
       return $pdf->stream('cobro');

  }
}


