@extends('layouts.app')
@section('content')
	<h1>Cita medica {{$data->title}}</h1>
	<p>Paciente: {{$data->nombres}} {{$data->apellidos}} </p>
	<p>Doctor: {{$data->nombrePro}} {{$data->apellidoPro}}</p>
	<p>Fecha de cita: {{$data->date}}</p>
	<p>Hora: {{$data->start_time}} Hasta las {{$data->end_time}}</p>
	<br>

	<h2>Datos del paciente</h2>
	<p>Nombre: {{$data->nombres}} {{$data->apellidos}} </p>
	<p>DNI paciente: {{$data->dni}}</p>
	<p>Direccion del paciente: {{$data->direccion}}</p>
	<p>Telefono del paciente: {{$data->telefono}}</p>
	<p>Fecha de nacimiento: {{$data->fechanac}}</p>
	<p>Grado de isntruccion del paciente: {{$data->gradoinstruccion}}</p>
	<p>Ocupacion del paciente: {{$data->ocupacion}}</p>	
    <p>Edad del paciente: {{$edad}} años</p>	


	<br>	

	@if($historial)
	<h2>Historia Base de {{$data->nombres}} {{$data->apellidos}}</h2>
		<p>Alergias: {{$historial->alergias}}</p>
		<p>Antecedentes patologicos: {{$historial->antecedentes_patologicos}}</p>
		<p>Antecedentes Personales: {{$historial->antecedentes_personales}}</p>
		<p>Antecedentes Familiares: {{$historial->antecedentes_familiar}}</p>
		<p>Menarquia: {{$historial->menarquia}}</p> años
		<p>1º R.S : {{$historial->prs}}</p> años

	@else
	<h4>Este usuario no cuenta con un historial base, por favor agregue uno</h4>
		<div></div>
		<form action="historial/create" method="post">
			<div class="form-group">
				{{ csrf_field() }}
				<input type="hidden" name="paciente_id" value="{{$data->pacienteId}}">
				<input type="hidden" name="profesional_id" value="{{$data->profesionalId}}">
				<h3>Antecedentes Medicos</h3>
				<div class="row">

				<label for="" class="col-sm-3">Antecedentes familiares</label>
				<div class="col-sm-3">
					<select id="el12" name="af">
							<option value="0">Seleccione</option>
							<option value="1">Ninguno</option>
							<option value="2">Otros</option>
						</select>
				</div>
				<div class="col-sm-3">
					<div id="af1"></div>
				</div>



				</div>
				<div class="row">

				<label for="" class="col-sm-3">Antecedentes personales</label>
				<div class="col-sm-3">			
						<select id="el11" name="ap">
														<option value="0">Seleccione</option>
							<option value="1">Ninguno</option>
							<option value="2">Otros</option>
						</select>
				</div>

				<div class="col-sm-3">
					<div id="ap1"></div>
				</div>
			  </div>

			  <div class="row">

				<label for="" class="col-sm-3">Antecedentes patologicos</label>
				<div class="col-sm-3">			
					<select id="el14" name="apa">
													<option value="0">Seleccione</option>
							<option value="1">Ninguno</option>
							<option value="2">Otros</option>
						</select>
				</div>
					<div class="col-sm-3">
					<div id="apa1"></div>
				</div>

				</div>
				<div class="row">

				<label for="" class="col-sm-3">Alergias</label>
				<div class="col-sm-3">
					<select id="el10" name="al">
					<option value="0">Seleccione</option>
					<option value="1">No</option>
					<option value="2">Si</option>
				</select>

				</div>
					<div class="col-sm-3">
					<div id="alerg"></div>
				</div>

					</div>
				


				<label for="" class="col-sm-3">Menarquia</label>
				<div class="col-sm-3">
					<input type="text" name="menarquia"> años.
				</div>
				<label for="" class="col-sm-3">1º R.S</label>
				<div class="col-sm-3">
					<input type="text" name="prs"> años.
				</div>
			
			
				<br>
				<div class="col-sm-12">
					<input type="button" onclick="form.submit()" value="Registrar" class="btn btn-success">
				</div>
			</div>
		</form>
	@endif
	<br>
	<h2>Resultados anteriores de {{$data->nombres}} {{$data->apellidos}}</h2>
	@foreach($consultas as $consulta)
	<div class="rows">
		<div class="col-sm-12">
			<div class="rows">
				<h3 class="col-sm-12"><strong>Consulta del {{$consulta->created_at}}</strong></h3>
				<p class="col-sm-6"><strong>Motivo de Consulta:</strong> {{ $consulta->mot}}</p>

				<p class="col-sm-6"><strong>Nombre de Madre/Padre:</strong> {{ $consulta->mp }}</p>
				<p class="col-sm-6"><strong>Tiempo Enfermedad:</strong> {{ $consulta->tenf }}</p>
				<p class="col-sm-6"><strong>Apetito:</strong> {{ $consulta->ape }}</p>
				<p class="col-sm-6"><strong>Frecuencia Micciones:</strong> {{ $consulta->orin }}</p>
				<p class="col-sm-6"><strong>Frecuencia Deposiciones:</strong> {{ $consulta->hec }}</p>
				<p class="col-sm-6"><strong>Sed:</strong> {{ $consulta->sed }}</p>
				<p class="col-sm-6"><strong>RAM:</strong> {{ $consulta->ram }}</p>
				<p class="col-sm-6"><strong>Hospitalizaciòn:</strong> {{ $consulta->hosp }}</p>
				<p class="col-sm-6"><strong>Cirugias:</strong> {{ $consulta->cir }}</p>
				<p class="col-sm-6"><strong>Vacunas:</strong> {{ $consulta->vac }}</p>
				<p class="col-sm-6"><strong>Antecedentes Patològicos:</strong> {{ $consulta->ap }}</p>
			    <p class="col-sm-6"><strong>Edad:</strong> {{ $consulta->edad }}</p>
				<p class="col-sm-6"><strong>Peso:</strong> {{ $consulta->peso }}</p>
				<p class="col-sm-6"><strong>Talla:</strong> {{ $consulta->talla }}</p>
				<p class="col-sm-6"><strong>1º:</strong> {{ $consulta->pri }}</p>
				<p class="col-sm-6"><strong>PA:</strong> {{ $consulta->pa }}</p>
				<p class="col-sm-6"><strong>SAT:</strong> {{ $consulta->sat }}</p>

				
				<p class="col-sm-6"><strong>Aspecto Gral:</strong>{{ $consulta->ag }}</p>
				<p class="col-sm-6"><strong>Cabeza: </strong>{{ $consulta->cab }}</p>
				<p class="col-sm-6"><strong>Apto.Digestivo: </strong>{{ $consulta->ad }}</p>
				<p class="col-sm-6"><strong>Sistema Neurològico: </strong>{{ $consulta->sn }}</p>
				<p class="col-sm-6"><strong>Piel: </strong>{{ $consulta->piel }}</p>
				<p class="col-sm-6"><strong>Torax/Sist.Resp: </strong>{{ $consulta->tor }}</p>
				<p class="col-sm-6"><strong>Sistem.Circulatorio: </strong>{{ $consulta->sc }}</p>
				<p class="col-sm-6"><strong>Sistem.Genitourinario: </strong>{{ $consulta->sg }}</p>
				<p class="col-sm-6"><strong>Apto.Locomotor:</strong> {{ $consulta->al }}</p>
				<p class="col-sm-6"><strong>Hallazgos: </strong>{{ $consulta->hall }}</p>
				<p class="col-sm-6"><strong>Diagnòstico.:</strong> {{ $consulta->diag }}</p>
				<p class="col-sm-6"><strong>Plan de Trabajo: </strong>{{ $consulta->plan }}</p>
				<p class="col-sm-6"><strong>Examen Auxiliar: </strong>{{ $consulta->exa }}</p>
				<p class="col-sm-6"><strong>Tratamiento y Evolucion: </strong>{{ $consulta->trat }}</p>
				<p class="col-sm-6"><strong>Proxima CITA </strong>{{ $consulta->prox }}</p>
		     


				<br>
			</div>
		</div>
	
	@endforeach
	<div class="col-sm-12">
	<h3>Registrar Nueva Historia</h3>
	<form action="pediatrico/create" method="post" class="form-horizontal">
		{{ csrf_field() }}
		<div class="form-group">
			<input type="hidden" name="paciente" value="{{$data->pacienteId}}">
			<input type="hidden" name="profesional_id" value="{{$data->profesionalId}}">
		    <input type="hidden" name="evento" value="{{$evento->id}}">
           <div class="row">
            <label for="" class="col-sm-2 control-label">Motivo de Consulta</label>
			<div class="col-sm-10 control-label">	
				<input  required class="form-control" type="text" name="mot">		
			</div>
		  </div>

		  <div class="row">
			<label for="" class="col-sm-2 control-label">Tiempo de Enfermedad</label>
			<div class="col-sm-10 control-label">	
				<input  required class="form-control" type="text" name="tenf">		
			</div>
		  </div>
		   <div class="row">
            
			<label for="" class="col-sm-2 control-label">Relato</label>
			<div class="col-sm-10 control-label">	
				<input  required class="form-control" type="textarea" name="rel">		
			</div>
		  </div>

		    <div class="row">
			<label for="" class="col-sm-2 control-label">Madre/Padre</label>
			<div class="col-sm-4 control-label">	
				<input  required class="form-control" type="text" name="mp">		
			</div>
		  </div>

		
          <div class="row">
		  <div class="col-md-6">
		  	            <label for="" class="col-sm-2 control-label">FUNCIONES BIOLÒGICAS</label>
		  </div>
		  </div>
		   
			 <label for="" class="col-sm-2 control-label">Apetito</label>
			<div class="col-sm-4">
				<select id="el7" name="ape">
					<option value="Aumentado">Aumentado</option>
					<option value="Normal">Normal</option>
					<option value="Disminuido">Disminuido</option>
				</select>
			</div>
			
	
			<label for="" class="col-sm-2 control-label">Sed:</label>
			<div class="col-sm-4">	
				<select id="el8" name="sed">
					<option value="Aumentado">Aumentado</option>
					<option value="Normal">Normal</option>
					<option value="Disminuido">Disminuido</option>
				</select>
			</div>
			
			
			<label for="" class="col-sm-2 control-label">Frecuencia.Micciones</label>
			<div class="col-sm-4">	
				<input   class="form-control" placeholder="Frecuencia Micciones" type="text" name="orin" placeholder="c 24/hrs">
			</div>
			
			<label for="" class="col-sm-2 control-label">Frecuencia.Deposiciones</label>
			<div class="col-sm-4">	
				<input  class="form-control" placeholder="Frecuencia Deposiciones" type="text" name="hec" placeholder="c 24/hrs">
			</div>
		
			
			<br>

			   <div class="row">
		  <div class="col-md-6">
		  	            <label for="" class="col-sm-2 control-label">ANTECEDENTES:</label>
		  </div>
		  </div>

		  <div class="row">

		  <label for="" class="col-sm-3">RAM</label>
				<div class="col-sm-3">
					<select id="el21" name="ram">
							<option value="0">Seleccione</option>
							<option value="No">No</option>
							<option value="Si">Si</option>
						</select>
				</div>

				<div class="col-sm-3">

					<input type="text" name="ram">
					
				</div>

		</div>

				  <div class="row">


			 <label for="" class="col-sm-3">Hospitalizaciòn</label>
				<div class="col-sm-3">
					<select id="el22" name="hosp">
							<option value="0">Seleccione</option>
							<option value="No">No</option>
							<option value="Si">Si</option>
						</select>
				</div>

				<div class="col-sm-3">

					<input type="text" name="hosp">
					
				</div>

			</div>

					  <div class="row">


			<label for="" class="col-sm-3">Cirugias</label>
				<div class="col-sm-3">
					<select id="el23" name="cir">
							<option value="0">Seleccione</option>
							<option value="No">No</option>
							<option value="Si">Si</option>
						</select>
				</div>

				<div class="col-sm-3">

					<input type="text" name="cir">
					
				</div>

				


			</div>

					  <div class="row">


		    <label for="" class="col-sm-3">Vacunas Completas</label>
				<div class="col-sm-3">
					<select id="el24" name="vac">
							<option value="0">Seleccione</option>
							<option value="Completas">Completas</option>
							<option value="Incompletas">Incompletas</option>
						</select>
				</div>

					<div class="col-sm-3">

					<input type="text" name="vac">
					
				</div>



			</div>

					  <div class="row">


			 <label for="" class="col-sm-3">Patològicos y Epidemiològicos</label>
				<div class="col-sm-3">
					<input  class="form-control" placeholder="Patològicos y Epidemiològicoss" type="text" name="ap">
				</div>

			</div>


			   <div class="row">
		  <div class="col-md-6">
		  	            <label for="" class="col-sm-2 control-label">EXAMEN FÌSICO:</label>
		  </div>
		  </div>


		  <div class="row">

		  <div class="col-md-2">Edad	
				<input class="form-control" type="text" name="edad">
			</div>
			<div class="col-md-2">Peso	
				<input class="form-control" type="text" name="peso">
			</div>
			<div class="col-md-2">Talla	
				<input class="form-control" type="text" name="talla">
			</div>
			<div class="col-md-2">T	
				<input class="form-control" type="text" name="pri">
			</div>
			<div class="col-md-2">PA	
				<input class="form-control" type="text" name="pa">
			</div>
			<div class="col-md-2">SAT	
				<input class="form-control" type="text" name="sat">
			</div>

			</div>

	  <div class="row">

		  <div class="col-md-3">Aspecto Gral	
				<select  name="ag">
					<option value="Normal">Normal</option>
					<option value="Anormal">Anormal</option>
			    </select>
			</div>

			 <div class="col-md-3">Cabeza
				<select  name="cab">
					<option value="Normal">Normal</option>
					<option value="Anormal">Anormal</option>
			    </select>
			</div>

			<div class="col-md-3">Apto Dig.
				<select  name="ad">
					<option value="Normal">Normal</option>
					<option value="Anormal">Anormal</option>
			    </select>
			</div>

			<div class="col-md-3">Sist.Neurològico
				<select  name="sn">
					<option value="Normal">Normal</option>
					<option value="Anormal">Anormal</option>
			    </select>
			</div>
			
			
			</div>

			


	  <div class="row">

		  <div class="col-md-3">Piel	
				<select  name="piel">
					<option value="Normal">Normal</option>
					<option value="Anormal">Anormal</option>
			    </select>
			</div>

			 <div class="col-md-3">Torax/Sist.Resp
				<select  name="tor">
					<option value="Normal">Normal</option>
					<option value="Anormal">Anormal</option>
			    </select>
			</div>

			<div class="col-md-3">Sist.Circul.
				<select  name="sc">
					<option value="Normal">Normal</option>
					<option value="Anormal">Anormal</option>
			    </select>
			</div>

			<div class="col-md-3">Sist.Genit.
				<select  name="sg">
					<option value="Normal">Normal</option>
					<option value="Anormal">Anormal</option>
			    </select>
			</div>

		
			</div>

			<div class="row">

		  <div class="col-md-3">Apto.Locomotor	
				<select  name="al">
					<option value="Normal">Normal</option>
					<option value="Anormal">Anormal</option>
			    </select>
			</div>

	
			</div>
			<br>
		
            <div class="row">
            	<div class="col-sm-6">
            		<strong>Describir los hallazgos descritos anormales</strong>
            	</div>
            	
            </div>
			
			
			<div class="col-sm-12">	
				<textarea name="hall" cols="10" rows="10" class="form-control" ></textarea>
			</div>

			 <div class="row">
            	<div class="col-sm-6">
            		<strong>DIAGNÒSTICO</strong>
            	</div>

            </div>

			<div class="col-sm-12">	
				<textarea name="diag" cols="10" rows="10" class="form-control" ></textarea>
			</div>

			 <div class="row">
            	<div class="col-sm-6">
            		<strong>PLAN DE TRABAJO</strong>
            	</div>

            </div>

			<div class="col-sm-12">	
				<textarea name="plan" cols="10" rows="10" class="form-control" ></textarea>
			</div>

			<div class="row">
            	<div class="col-sm-6">
            		<strong>EXAMENES AUXILIARES</strong>
            	</div>

            </div>

			<div class="col-sm-12">	
				<textarea name="exa" cols="10" rows="10" class="form-control" ></textarea>
			</div>

			<div class="row">
            	<div class="col-sm-6">
            		<strong>TRATAMIENTO Y EVOLUCIÒN</strong>
            	</div>

            </div>

			<div class="col-sm-12">	
				<textarea name="trat" cols="10" rows="10" class="form-control" ></textarea>
			</div>
			<br>
			<label for="" class="col-sm-2 ">Pròxima Cita</label>
			<div class="col-sm-3">
				<input type="date" name="prox" class="form-control" >
			</div>
		
			
		
            <!-- sheepIt Form -->
            <div id="laboratorios" class="embed ">
            
                <!-- Form template-->
                <div id="laboratorios_template" class="template row">

                    

                   

                    <a id="laboratorios_remove_current" style="cursor: pointer;"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                </div>
                <!-- /Form template-->
                
                <!-- No forms template -->
                <div id="laboratorios_noforms_template" class="noItems col-sm-12 text-center">Ningún laboratorios</div>
                <!-- /No forms template-->
                
                <!-- Controls -->
             
                <!-- /Controls -->
                
            </div>
            <!-- /sheepIt Form --> 
						
					</div>
          <hr>

       
			
		
			<div class="col-sm-12">
				<input type="button" onclick="form.submit()" value="Registrar" class="btn btn-success" class="form-control">
			</div>
		</div>
		</div>
	</form>
	</div>
</div>
@section('scripts')
<script src="{{ asset('plugins/sheepit/jquery.sheepItPlugin.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jqNumber/jquery.number.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">

  $(document).ready(function() {

    $(".monto").keyup(function(event) {
      var montoId = $(this).attr('id');
      var montoArr = montoId.split('_');
      var id = montoArr[1];
      var montoH = parseFloat($('#servicios_'+id+'_montoHidden').val());
      var monto = parseFloat($(this).val());
      $('#servicios_'+id+'_montoHidden').val(monto);
      calcular();
      calculo_general();
    });

    $(".montol").keyup(function(event) {
      var montoId = $(this).attr('id');
      var montoArr = montoId.split('_');
      var id = montoArr[1];
      var montoH = parseFloat($('#laboratorios_'+id+'_montoHidden').val());
      var monto = parseFloat($(this).val());
      $('#laboratorios_'+id+'_montoHidden').val(monto);
      calcular();
      calculo_general();
    });

    $(".abonoL, .abonoS").keyup(function(){
      var total = 0;
      var selectId = $(this).attr('id');
      var selectArr = selectId.split('_');
      
      if(selectArr[0] == 'servicios'){
          if(parseFloat($(this).val()) > parseFloat($("#servicios_"+selectArr[1]+"_monto").val())){
              alert('La cantidad insertada en abono es mayor al monto.');
              $(this).val('0.00');
              calculo_general();
          } else {
              calculo_general();
          }
      } else {
        if(parseFloat($(this).val()) > parseFloat($("#laboratorios_"+selectArr[1]+"_monto").val())){
              alert('La cantidad insertada en abono es mayor al monto.');
              $(this).val('0.00');
              calculo_general();
          } else {
              calculo_general();
          }
      }
    });

    var botonDisabled = true;

    // Main sheepIt form
    var phonesForm = $("#laboratorios").sheepIt({
        separator: '',
        allowRemoveCurrent: true,
        allowAdd: true,
        allowRemoveAll: true,
        allowRemoveLast: true,

        // Limits
        maxFormsCount: 10,
        minFormsCount: 1,
        iniFormsCount: 0,

        removeAllConfirmationMsg: 'Seguro que quieres eliminar todos?',
        
        afterRemoveCurrent: function(source, event){
          calcular();
          calculo_general();
        }
    });

 
    $(document).on('change', '.selectLab', function(){
      var labId = $(this).attr('id');
      var labArr = labId.split('_');
      var id = labArr[1];

      $.ajax({
         type: "GET",
         url:  "analisis/getAnalisi/"+$(this).val(),
         success: function(a) {
            $('#laboratorios_'+id+'_montoHidden').val(a.preciopublico);
            $('#laboratorios_'+id+'_monto').val(a.preciopublico);
            var total = parseFloat($('#total').val());
            $("#total").val(total + parseFloat(a.preciopublico));
            calcular();
            calculo_general();
         }
      });
    })
});


function calcular() {
  var total = 0;
      $(".monto").each(function(){
        total += parseFloat($(this).val());
      })

      $(".montol").each(function(){
        total += parseFloat($(this).val());
      })

      $("#total").val(total);
}

function calculo_general() {
  var total = 0;
  $(".abonoL").each(function(){
    total += parseFloat($(this).val());
  })

  $(".abonoS").each(function(){
    total += parseFloat($(this).val());
  })

  $("#total_a").val(total);
  $("#total_g").val(parseFloat($("#total").val()) - parseFloat(total));
}

// Run Select2 on element
function Select2Test(){
	$("#el2").select2();
	$("#el1").select2();
	$("#el3").select2();
  $("#el5").select2();
  $("#el4").select2();
  $("#el6").select2();
  $("#el7").select2();
  $("#el8").select2();
  $("#el9").select2();
  $("#el10").select2();
  $("#el11").select2();
  $("#el12").select2();
    $("#el13").select2();
  $("#el14").select2();
    $("#el15").select2();
  $("#el16").select2();
  $("#el17").select2();
  $("#el21").select2();
  $("#el22").select2();
  $("#el23").select2();
  $("#el24").select2();
  $("#el25").select2();
  $("#el26").select2();
  $("#el27").select2();
  $("#el28").select2();





}
$(document).ready(function() {
	// Load script of Select2 and run this
	LoadSelect2Script(Select2Test);
	LoadTimePickerScript(DemoTimePicker);
	WinMove();
});

function DemoTimePicker(){
	$('#input_date').datepicker({
	setDate: new Date(),
	minDate: 0});
	$('#input_time').timepicker({
		setDate: new Date(),
		stepMinute: 10
	});
	$('#input_time2').timepicker({
		setDate: new Date(),
		stepMinute: 10
	});
}
</script>



<script type="text/javascript">
      $(document).ready(function(){
        $('#el12').on('change',function(){
          var link;
          if ($(this).val() ==  2) {
            link = '/af/otros/';
          } else {
           link = '/af/ningunof/';
          }

          $.ajax({
                 type: "get",
                 url:  link,
                 success: function(a) {
                    $('#af1').html(a);
                 }
          });

        });
        

      });
       
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#el11').on('change',function(){
          var link;
          if ($(this).val() ==  2) {
            link = '/ap/otros/';
          } else {
           link = '/ap/ningunop/';
          }

          $.ajax({
                 type: "get",
                 url:  link,
                 success: function(a) {
                    $('#ap1').html(a);
                 }
          });

        });
        

      });
       
    </script>

        <script type="text/javascript">
      $(document).ready(function(){
        $('#el14').on('change',function(){
          var link;
          if ($(this).val() ==  2) {
            link = '/apa/otros/';
          } else {
           link = '/apa/ningunopa/';
          }

          $.ajax({
                 type: "get",
                 url:  link,
                 success: function(a) {
                    $('#apa1').html(a);
                 }
          });

        });
        

      });
       
    </script>


        <script type="text/javascript">
      $(document).ready(function(){
        $('#el10').on('change',function(){
          var link;
          if ($(this).val() ==  2) {
            link = '/alerg/si/';
          } else {
           link = '/alerg/no/';
          }

          $.ajax({
                 type: "get",
                 url:  link,
                 success: function(a) {
                    $('#alerg').html(a);
                 }
          });

        });
        

      });
       
    </script>



@endsection
@endsection