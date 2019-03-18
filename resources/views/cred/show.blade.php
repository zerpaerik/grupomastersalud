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
	<h2>Resultados anteriores de {{$data->nombres}} {{$data->apellidos}}</h2>
	@foreach($cred as $consulta)
	<div class="rows">
		<div class="col-sm-6">
			<div class="rows">
				<h3 class="col-sm-12"><strong>Consulta del {{$consulta->created_at}}</strong></h3>
				<p class="col-sm-6"><strong>Edad:</strong> {{ $consulta->edad }}-</p>

				<p class="col-sm-6"><strong>Peso:</strong> {{ $consulta->peso }}gr</p>
				<p class="col-sm-6"><strong>Talla:</strong> {{ $consulta->talla }}</p>
				<p class="col-sm-6"><strong>Perim Cefàlico:</strong> {{ $consulta->perim }}</p>
				<br>
			</div>
		</div>
	@endforeach
	<div class="col-sm-12">
	<h3>Registrar nueva Historia CRED</h3>
	<form action="cred/create" method="post" class="form-horizontal">
		{{ csrf_field() }}
		<div class="form-group">
			<input type="hidden" name="paciente" value="{{$data->pacienteId}}">
			<input type="hidden" name="profesional_id" value="{{$data->profesionalId}}">
		    <input type="hidden" name="evento" value="{{$evento->id}}">

		    	<label class="col-sm-2 control-label">Edad</label>
			<div class="col-sm-4">
				<select id="el6" name="edad">
					<option value="2d">2d</option>
				    <option value="7d">7d</option>
					<option value="12d">12d</option>
					<option value="21d">21d</option>
					<option value="1m">1m</option>
					<option value="2m">2m</option>
					<option value="3m">3m</option>
					<option value="4m">4m</option>
					<option value="5m">5m</option>
					<option value="6m">6m</option>
					<option value="7m">7m</option>
					<option value="8m">8m</option>
					<option value="9m">9m</option>
					<option value="10m">10m</option>
					<option value="11m">11m</option>
					<option value="1 año">1</option>
					<option value="1 a 1m">1 a 1m</option>
					<option value="1 a 2m">1 a 2m</option>
				    <option value="1 a 3m">1 a 3m</option>
					<option value="1 a 4m">1 a 4m</option>
					<option value="1 a 5m">1 a 5m</option>
					<option value="1 a 6m">1 a 6m</option>
					<option value="1 a 7m">1 a 7m</option>
					<option value="1 a 8m">1 a 8m</option>
					<option value="1 a 9m">1 a 9m</option>
				    <option value="1 a 10m">1 a 10m</option>
					<option value="1 a 11m">1 a 11m</option>
					<option value="2 años">2 años</option>
					<option value="2 a 1m">2 a 1m</option>
					<option value="2 a 2m">2 a 2m</option>
			



				</select>
			</div> 
            
         
			<label for=""class="col-sm-2 control-label">Peso(gr)</label>
			<div class="col-sm-4">
				<input class="form-control" type="text" name="peso" placeholder="Peso">
			</div>
			

			<label for="" class="col-sm-2 control-label">Talla(cm)</label>
			<div class="col-sm-4">	
				<input   class="form-control" placeholder="Talla" type="text" name="talla" placeholder="c 24/hrs">
			</div>

			<label for="" class="col-sm-2 control-label">Perim Cefàlico</label>
			<div class="col-sm-4">			
				<input  class="form-control" type="text" name="perim" placeholder="Perim Cefàlico">
			</div>
			
			

			
	
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