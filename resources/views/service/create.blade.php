@extends('layouts.app')

@section('content')
<br>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-users"></i>
					<span><strong>Nueva Programación</strong></span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content">
				<h4 class="page-header"></h4>
				<form class="form-horizontal" role="form" method="post" action="services/create">
					{{ csrf_field() }}
					<div class="form-group">

					    <label class="col-sm-1 control-label">Paciente</label>
						<div class="col-sm-3">
							<select id="el4" name="paciente">
								@foreach($pacientes as $atec)
									<option value="{{$atec->id}}">
										{{$atec->nombres}},{{$atec->apellidos}} DNI:{{$atec->dni}}
									</option>
								@endforeach
							</select>
						</div>
						
						<label class="col-sm-1 control-label">Servicio</label>
						<div class="col-sm-3">
							<select id="el1" name="servicio">
								@foreach($servicios as $serv)
									<option value="{{$serv->id}}">
										{{$serv->detalle}}
									</option>
								@endforeach
							</select>
						</div>
						
						<label class="col-sm-1 control-label">Especialista</label>
						<div class="col-sm-3">
							<select id="el2" name="especialista">
								@foreach($especialistas as $esp)
									<option value="{{$esp->id}}">
										{{$esp->name}},{{$esp->lastname}}
									</option>
								@endforeach
							</select>
						</div>
						<label class="col-sm-1 control-label">Fecha</label>
						<div class="col-sm-3">
							<input type="text" id="input_date" class="form-control" placeholder="Fecha" name="date" required="required">
						</div>
						<label class="col-sm-1 control-label">Hora</label>
							<div class="col-sm-3">
								<select id="el3" name="time">
									@foreach($tiempos as $tiempo)
										<option value="{{$tiempo->id}}">
											{{$tiempo->start_time}} {{$tiempo->end_time}}
										</option>
									@endforeach
								</select>
							</div>						

						<br>
						<input onclick="form.submit()"  type="submit" style="margin-left:15px; margin-top: 20px;" class="col-sm-2 btn btn-primary" value="Agregar">

						<a href="#" style="margin-left:15px; margin-top: 20px;" class="col-sm-2 btn btn-danger">Volver</a>
					</div>			
				</form>	
			</div>
		</div>
	</div>
</div>
@section('scripts')
<script type="text/javascript">
// Run Select2 on element
$(document).ready(function() {
	LoadTimePickerScript(DemoTimePicker);
	LoadSelect2Script(function (){
		$("#el2").select2();
		$("#el9").select2();
		$("#el1").select2();
		$("#el4").select2();
		$("#el3").select2({disabled : true});
	});
	WinMove();
});

$('#input_date').on('change', getAva);
$('#el1').on('change', getAva);

function getAva (){
		var d = $('#input_date').val();
		var e = $("#el1").val();
		if(!d) return;
		$.ajax({
      url: "service-available-time/"+e+"/"+d,
      headers: {
    		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  		},
      type: "get",
      success: function(res){
      	$('#el3').find('option').remove().end();
      	for(var i = 0; i < res.length; i++){
					var newOption = new Option(res[i].start_time+"-"+res[i].end_time, res[i].id, false, false);
					$('#el3').append(newOption).trigger('change');
      	}
      }
    });	
}

function DemoTimePicker(){
	$('#input_date').datepicker({
	setDate: new Date(),
	minDate: 0});
}
</script>
@endsection
@endsection
