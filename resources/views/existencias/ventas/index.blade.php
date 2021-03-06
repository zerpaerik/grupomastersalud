@extends('layouts.app')

@section('content')

<body>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-linux"></i>
					<span>Listado de Ventas</span>

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
			{!! Form::open(['method' => 'get', 'route' => ['ventas.index']]) !!}

			<div class="row">
				<div class="col-md-2">
					{!! Form::label('fecha', 'Fecha Inicio', ['class' => 'control-label']) !!}
					{!! Form::date('fecha', old('fechanac'), ['id'=>'fecha','class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
					<p class="help-block"></p>
					@if($errors->has('fecha'))
					<p class="help-block">
						{{ $errors->first('fecha') }}
					</p>
					@endif
				</div>
				<div class="col-md-2">
					{!! Form::label('fecha2', 'Fecha Fin', ['class' => 'control-label']) !!}
					{!! Form::date('fecha2', old('fecha2'), ['id'=>'fecha2','class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
					<p class="help-block"></p>
					@if($errors->has('fecha2'))
					<p class="help-block">
						{{ $errors->first('fecha2') }}
					</p>
					@endif
				</div>
				<div class="col-md-2">
					{!! Form::submit(trans('Buscar'), array('class' => 'btn btn-info')) !!}
					{!! Form::close() !!}

				</div>
			</div>	

			<div class="row">
				<div class="col-md-2">
				<strong>Total:</strong>{{$aten->monto}} Soles
			   </div>

			   <div class="col-md-2">
				<strong>Cantidad:</strong>{{$cantidad->cantidad}} Venta
			   </div>
				
			</div>


			<div class="box-content no-padding">
				<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-3">
					<thead>
						<tr>
							<th>Nro</th>
							<th>Paciente</th>
							<th>Productos</th>
							<th>Monto Total</th>
							<th>Usuario</th>
						    <th>Fecha</th>
						    <th>Acciones</th>
						</tr>
					</thead>
					<tbody>
                         @foreach($atenciones as $atec)	

							<tr>
								<td>{{$atec->id}}</td>
						        <td>{{$atec->nombres}},{{$atec->apellidos}}</td>
						        <td>{{$ventas->selectProductos($atec->id)}}</td>
						        <td>{{$ventasp->montoVenta($atec->id)}}</td>
								<td>{{$atec->name}},{{$atec->lastname}}</td>
								<td>{{$atec->created_at}}</td>
								<td>
									<a target="_blank" href="ticket_ver_ventas-{{$atec->id}}" class="btn btn-success">Ver Ticket</a>
								@if(\Auth::user()->role_id <> 6)
									<a class="btn btn-danger" href="ventas-delete-{{$atec->id3}}"  onclick="return confirm('¿Desea Eliminar este registro?')">Eliminar</a>	
								</td>
								@endif
							</tr>
						@endforeach
					</tbody>
					<tfoot>
					        <th>Nro</th>
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Monto</th>
							<th>Usuario</th>
						    <th>Fecha</th>

					</tfoot>

				</table>
			</div>
		</div>
	</div>
</div>

</body>




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
