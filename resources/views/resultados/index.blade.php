@extends('layouts.app')

@section('content')

<body>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-linux"></i>
					<span>Resultados/Redactar Servicios</span>

				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>

			{!! Form::open(['method' => 'get', 'route' => ['resultados.index']]) !!}

			<div class="row">
				<div class="col-md-2">
					<label>Fecha Inicio</label>
					<input type="date" value="" name="fecha" style="line-height: 20px">
				</div>
				<div class="col-md-2">
					<label>Fecha Fin</label>
					<input type="date" value="" name="fecha2" style="line-height: 20px">
				</div>
                        <div class="col-md-3">
                              {!! Form::label('name', '*', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Buscar por Detalle']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('name'))
                            <p class="help-block">
                                {{ $errors->first('name') }}
                          </p>
                          @endif
                    </div>
				<div class="col-md-2">
					{!! Form::submit(trans('Buscar'), array('class' => 'btn btn-info')) !!}
					{!! Form::close() !!}

				</div>
			</div>	
			<div class="box-content no-padding">
				<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-3">
					<thead>
						<tr>
							<th>Id</th>
							<th>Fecha</th>
							<th>Paciente</th>
							<th>Origen</th>
							<th>Servicio</th>
							<th>Informe</th>
							<th>Acciones:</th>
							


						</tr>
					</thead>
					<tbody>
					@foreach($data as $p)					
						<tr>
						<td>{{$p->id}}</td>
						<td>{{$p->created_at}}</td>
						<td>{{$p->nombres}},{{$p->apellidos}}</td>
						<td>{{$p->name}},{{$p->lastname}}</td>
						<td>{{$p->servicio}}</td>
						
					
						  
							@if($p->informe)
						<td>

					    <a href="resultados-desoc-{{$p->id}}" class="btn btn-success">Reversar</a>
	
						<a href="/modelo-informe-{{$p->id}}-{{$p->informe}}" class="btn btn-danger" target="_blank">Descargar Modelo</a>
							
						<td><a class="btn btn-primary" href="/resultados-guardar-{{$p->id}}">Adjuntar Informe</a></td>

							@else
								<td>
								<form action="{{$model . '-asoc-' .$p->id}}" method="get">
						<select name="informe" id="informe">
							<option value="">Seleccione</option>
							<option value="11 PELVICA NANCY MAYTAN TAQUIA.docx">11 PELVICA NANCY MAYTAN TAQUIA</option>
							<option value="32 LCI C SIMPLE NOEMI MEDINA HUACAL.docx">32 LCI C SIMPLE NOEMI MEDINA HUACAL</option>
							<option value="38.6 LCD C DOBLE ISABEL RAMOS QUISPE.docx">38.6 LCD C DOBLE ISABEL RAMOS QUISPE</option>
							<option value="40 LCI C SIMPLE MACROSOMIA FIORELLA PUMAYAULI HUAMAYAURI.docx">40 LCI C SIMPLE MACROSOMIA FIORELLA PUMAYAULI HUAMAYAURI</option>
							<option value="COLECISTOPATIA CRONICA CALCULOSA ROCIO YANAC ORENCIO.docx">COLECISTOPATIA CRONICA CALCULOSA ROCIO YANAC ORENCIO</option>
							<option value="ESTEATOSIS HEPATICA METEO POLIPO MIRIAN LAUREANO TORIBIO.docx">ESTEATOSIS HEPATICA METEO POLIPO MIRIAN LAUREANO TORIBIO</option>
							<option value="FORMATO  GEMELAR.docx">FORMATO  GEMELAR</option>
							<option value="FORMATO ECO DOPPLER Dario Cardenas Mauricio.docx">FORMATO ECO DOPPLER Dario Cardenas Mauricio</option>
							<option value="FORMATO ECO GENETICA Dario Cardenas Mauricio.docx">FORMATO ECO GENETICA Dario Cardenas Mauricio</option>
							<option value="FORMATO ECO OBSTETRICA 2DO TRIMESTRE Dario Cárdenas Mauricio.docx">FORMATO ECO OBSTETRICA 2DO TRIMESTRE Dario Cárdenas Mauricio</option>
							<option value="FORMATO ECO OBSTETRICA INICIAL.docx">FORMATO ECO OBSTETRICA INICIAL</option>
							<option value="FORMATO ECOGRAFIA MORFOLOGICA O 4D Dario Cárdenas Mauricio.docx">FORMATO ECOGRAFIA MORFOLOGICA O 4D Dario Cárdenas Mauricio</option>
							<option value="FORMATO ECOGRAFIA TRANSVAGINAL Dario Cárdenas Mauricio.docx">FORMATO ECOGRAFIA TRANSVAGINAL Dario Cárdenas Mauricio</option>
							<option value="HERIDA OPERATORIA CESAREA SAE JENY MENDEZ FELIPE.docx">HERIDA OPERATORIA CESAREA SAE JENY MENDEZ FELIPE</option>
							<option value="LCD 29 SS JESICA CAMPOS CACERES.docx">LCD 29 SS JESICA CAMPOS CACERES</option>
							<option value="LPD 16 SS YOSY CUTIPA LLANTOY.docx">LPD 16 SS YOSY CUTIPA LLANTOY</option>
							<option value="MAMA LACTANCIA VARICES DER MARÍA ORTIZ PAREDES.docx">MAMA LACTANCIA VARICES DER MARÍA ORTIZ PAREDES</option>
							<option value="MAMA SAE ROSMERY RICSE RODRIGUEZ.docx">MAMA SAE ROSMERY RICSE RODRIGUEZ</option>
							<option value="METEO PERISTALTISMO INCREMENTADO RUBY CAJAS HERRERA.docx">METEO PERISTALTISMO INCREMENTADO RUBY CAJAS HERRERA</option>
							<option value="MOLA PARCIAL MARIBEL CORTEZ TACSA.docx">MOLA PARCIAL MARIBEL CORTEZ TACSA</option>
							<option value="OBST 17 MAYRA CRISTOBAL REYES.docx">OBSTÈTRICA</option>
							<option value="PELVICA SAE PARAMETRIO CONSERVADO, TROMPA NO VISUALIZABLE, OVARIO NO SE APRECIA POR INTERFERENCIA DE GASES.docx">PELVICA</option>
							<option value="PIG METEO CAO SHUZHEN.docx">PIG METEO CAO SHUZHEN</option>
							<option value="PROSTATA III.docx">PROSTATA III</option>
							<option value="RENAL SAE MIRIAN LAUREANO TORIBIO.docx">RENAL</option>
							<option value="TV  MIOMA ELENA GOMEZ QUEZADA.docx">TRANSVAGINAL</option>
				
								</select>
							</td>
							<td><input type="submit" class="btn btn-success" value="Asociar"></td>
							@endif
							
						</tr>
						</form>
						@endforeach	
					</tbody>
					<tfoot>
						<tr>
						    <th>Id</th>
							<th>Fecha</th>
							<th>Paciente</th>
							<th>Origen</th>
							<th>Detalle</th>
							<th>Informe</th>
							<th>Acciones:</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

</body>



<script src="{{url('/tema/plugins/jquery-ui/jquery-ui.min.js')}}"></script>




<script type="text/javascript">
// Run Datables plugin and create 3 variants of settings
function AllTables(){
	TestTable1();
	TestTable2();
	TestTable3();
	LoadSelect2Script(MakeSelect2);
}
function MakeSelect2(){
	$('select').select2();
	$('.dataTables_filter').each(function(){
		$(this).find('label input[type=text]').attr('placeholder', 'Search');
	});
}
$(document).ready(function() {
	// Load Datatables and run plugin on tables 
	LoadDataTablesScripts(AllTables);
	// Add Drag-n-Drop feature
	WinMove();
});
</script>
@endsection
