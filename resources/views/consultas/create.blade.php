@extends('layouts.app')

@section('content')
<br>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-users"></i>
					<span><strong>Nueva Consulta</strong></span>
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
			   <a href="{{route('pacientes.create3')}}"><i class="fa fa-wheelchair"></i> Crear Pacientes<a>

			<div class="box-content">
				<h4 class="page-header"></h4>
				<form class="form-horizontal" role="form" method="post" action="consulta/create">
					{{ csrf_field() }}

					<div class="form-group">
              <label class="col-sm-1 control-label">Pacientes</label>
            <div class="col-sm-5">
              <select id="el2" name="paciente">
                @foreach($pacientes as $paciente)
                  <option value="{{$paciente->id}}">
                    {{$paciente->dni}} - 
                    {{$paciente->nombres}} {{$paciente->apellidos}}
                  </option>
                @endforeach
              </select>
            </div>
						
						<label class="col-sm-1 control-label">Especialistas</label>
						<div class="col-sm-5">
							<select id="el1" name="especialista">

								@foreach($especialistas as $paciente)
									<option value="{{$paciente->id}}">
										{{$paciente->dni}} - 
										{{$paciente->name}} {{$paciente->lastname}}
									</option>
								@endforeach
									
									

							</select>
						</div>


						<label class="col-sm-1 control-label">Tipo</label>
						<div class="col-sm-4">
							<select id="el4" name="tipoc">
								@foreach($tipo as $t) 
									<option value="{{$t->id}}">
										{{$t->detalle}}-Precio:{{$t->precio}}
									</option>
								@endforeach
							</select>
						</div>

            @if(\Auth::user()->role_id == 6)             

						<label class="col-sm-1 control-label">Monto</label>
						<div class="col-sm-2">
							<input type="number" class="form-control" placeholder="Monto" name="monto" required="required" disabled="">
						</div>
            @elseif(\Auth::user()->role_id == 7)
            <label class="col-sm-1 control-label">Monto</label>
            <div class="col-sm-2">
              <input type="number" class="form-control" placeholder="Monto" name="monto" required="required" disabled="">
            </div>
            @else
            <label class="col-sm-1 control-label">Monto</label>
            <div class="col-sm-2">
              <input type="number" class="form-control" placeholder="Monto" name="monto" required="required">
            </div>
            @endif


					

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

							<label class="col-sm-1 control-label">TipoPago</label>
							<div class="col-sm-3">
								<select id="el5" name="tipopago">
										<option value="EF">EF</option>
										<option value="EF">TJ</option>
								</select>
							</div>

							
						<br>
						<input type="button" onclick="form.submit()" style="margin-left:15px; margin-top: 20px;" class="col-sm-3 btn btn-primary" value="Agregar">

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
		$("#el1").select2();
		$("#el4").select2();
		$("#el5").select2();
		$("#el6").select2();
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
      url: "available-time/"+e+"/"+d,
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

  $(document).on('change','.selecTipo',function(){
      var labId = $(this).attr('id');
      var labArr = labId.split('_');
      var id = labArr[1];

      $.ajax({
         type: "GET",
         url:  "tipo/getTipo/"+$(this).val(),
         success: function(a) {
           
            $('#servicios_'+id+'_montoHidden').val(a.precio);
            $('#servicios_'+id+'_monto').val(a.precio);

         }
      });
    })

function DemoTimePicker(){
	$('#input_date').datepicker({
	setDate: new Date(),
	minDate: 0});
}
</script>
@endsection
@endsection
