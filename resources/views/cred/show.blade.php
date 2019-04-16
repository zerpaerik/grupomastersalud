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
  <br>
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

    <div class="row">
      <h3 class="col-sm-12">VACUNAS</h3>  
        <div class="col-sm-6"><strong>BCG (TUBERCULOSIS) (RN):</strong>  
          <input class="form-control" type="date" value="{{$consulta->bcg}}" disabled="">
        </div>
        <div class="col-sm-6"><strong>HVB (ANTI-HEPATITIS) (RN):</strong> 
          <input class="form-control" type="date" value="{{$consulta->hvb}}" disabled="">
        </div>
    </div>
    <div class="row">
      <label class="col-sm-12" for="">ANTIPOLIO:</label>
        <div class="col-sm-3"><strong>1º dosis (2 meses) INY-IPV</strong>
          <input class="form-control" type="date" value="{{$consulta->atp1}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>2º dosis (4 meses) INY-IPV</strong>  
          <input class="form-control" type="date" value="{{$consulta->atp2}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>3º dosis (6 meses) ORAL-APO</strong>  
          <input class="form-control" type="date" value="{{$consulta->atp3}}" disabled="">
        </div>
    </div>
    <div class="row">
      <label class="col-sm-12" for="">PENTAVALENTE (DPT + HIB HVB):</label>
        <div class="col-sm-3"><strong>1º dosis (2 meses)</strong>
          <input class="form-control" type="date" value="{{$consulta->pent1}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>2º dosis (4 meses)</strong>  
          <input class="form-control" type="date" value="{{$consulta->pent2}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>3º dosis (6 meses)</strong>  
          <input class="form-control" type="date" value="{{$consulta->pent3}}" disabled="">
        </div>
    </div>
    <div class="row">
      <label class="col-sm-12" for="">NEUMOCOCO:</label>
        <div class="col-sm-3"><strong>1º dosis (2 meses)</strong>
          <input class="form-control" type="date" value="{{$consulta->neu1}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>2º dosis (4 meses)</strong>  
          <input class="form-control" type="date" value="{{$consulta->neu2}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>3º dosis (12 meses)</strong>  
          <input class="form-control" type="date" value="{{$consulta->neu3}}" disabled="">
        </div>
    </div>
    <div class="row">
      <label class="col-sm-12" for="">ROTAVIRUS:</label>
        <div class="col-sm-3"><strong>1º dosis (2 meses)</strong>
          <input class="form-control" type="date" value="{{$consulta->rot1}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>2º dosis (4 meses)</strong>  
          <input class="form-control" type="date" value="{{$consulta->rot2}}" disabled="">
        </div>
    </div>
    <div class="row">
      <label class="col-sm-12" for="">ROTAVIRUS:</label>
        <div class="col-sm-3"><strong>1º dosis (7 meses)</strong>
          <input class="form-control" type="date" value="{{$consulta->rot3}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>2º dosis (8 meses)</strong>  
          <input class="form-control" type="date" value="{{$consulta->rot4}}" disabled="">
        </div>
    </div>
    <div class="row">
      <div class="col-sm-3"><strong>1 año</strong>
          <input class="form-control" type="date" value="{{$consulta->ano1}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>2 años</strong>  
          <input class="form-control" type="date" value="{{$consulta->ano2}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>3 años</strong>
          <input class="form-control" type="date" value="{{$consulta->ano3}}" disabled="">
        </div>

        <div class="col-sm-3"><strong>4 años</strong>  
          <input class="form-control" type="date" value="{{$consulta->ano4}}" disabled="">
        </div>
    </div>
    <div class="row">
      <div class="col-sm-6" for=""><label>SPR (SARAMPIÓN, PAPERA, RUBEÓLA):</label>
          <div class="col-sm-6"><strong>1º dosis (12 meses)</strong>  
            <input class="form-control" type="date" value="{{$consulta->spr1}}" disabled="">
          </div>
          <div class="col-sm-6"><strong>2º dosis (18 meses)</strong>  
            <input class="form-control" type="date" value="{{$consulta->spr2}}" disabled="">
          </div>
        </div>

        <div class="col-sm-3"><label>VARICELA:</label>
          <div class="col-sm-12"><strong>1º dosis (12 meses)</strong> 
            <input class="form-control" type="date" value="{{$consulta->vari}}" disabled="">
          </div>
        </div>


        <div class="col-sm-3"><label>ANTIAMARÍLICA:</label> 
          <div class="col-sm-12"><strong>(15 meses)</strong> 
          <input class="form-control" type="date" value="{{$consulta->antia}}" disabled="">
        </div>
        </div>
    </div>
    <div class="row">
      <label class="col-sm-12" for="">REFUERZOS:</label>
        <div class="col-sm-6"><strong>1º REF. DPT (18 meses)</strong>
          <input class="form-control" type="date" value="{{$consulta->ref1}}" disabled="">
        </div>

        <div class="col-sm-6"><strong>2º REF. DPT (4 años)</strong>  
          <input class="form-control" type="date" value="{{$consulta->ref2}}" disabled="">
        </div>
    </div>
    <div class="row">
      <div class="col-sm-6"><strong>1º REF Antipolio (Oral 18 meses)</strong>
          <input class="form-control" type="date" value="{{$consulta->ref3}}" disabled="">
        </div>

        <div class="col-sm-6"><strong>2º REF Antipolio (Oral 4 años)</strong>  
          <input class="form-control" type="date" value="{{$consulta->ref4}}" disabled="">
        </div>
    </div>
    <div class="row">
      <label class="col-sm-12" for="">OTRAS VACUNAS:</label>
        <div class="col-sm-4">
          <input type="text" value="{{$consulta->otra1}}" disabled="" style="width: 100%">
          <input class="form-control" type="date" value="{{$consulta->ot1}}" disabled="">
        </div>

        <div class="col-sm-4">
          <input type="text" value="{{$consulta->otra2}}" disabled="" style="width: 100%">  
          <input class="form-control" type="date" value="{{$consulta->ot2}}" disabled="">
        </div>

        <div class="col-sm-4">
          <input type="text" value="{{$consulta->otra3}}" disabled="" style="width: 100%">  
          <input class="form-control" type="date" value="{{$consulta->ot3}}" disabled="">
        </div>
    </div>
    <div class="row">
      <label class="col-sm-12" for="">OBSERVACIONES:</label>
        <div class="col-sm-12">
          <input type="text" value="{{$consulta->observs}}" disabled="" style="width: 100%">
        </div>
    </div>
	@endforeach
  <br>
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
			
     <br>
      <div class="row">
        <h3 class="col-sm-12">VACUNAS</h3>  
        <div class="col-sm-6"><strong>BCG (TUBERCULOSIS) (RN):</strong>  
          <input class="form-control" type="date" name="bcg">
        </div>
        <div class="col-sm-6"><strong>HVB (ANTI-HEPATITIS) (RN):</strong> 
          <input class="form-control" type="date" name="hvb">
        </div>


      </div>

      <div class="row">

        <label class="col-sm-12" for="">ANTIPOLIO:</label>
        <div class="col-sm-3"><strong>1º dosis (2 meses) INY-IPV</strong>
          <input class="form-control" type="date" name="atp1">
        </div>

        <div class="col-sm-3"><strong>2º dosis (4 meses) INY-IPV</strong>  
          <input class="form-control" type="date" name="atp2">
        </div>

        <div class="col-sm-3"><strong>3º dosis (6 meses) ORAL-APO</strong>  
          <input class="form-control" type="date" name="atp3">
        </div>

      </div>

      <div class="row">

        <label class="col-sm-12" for="">PENTAVALENTE (DPT + HIB HVB):</label>
        <div class="col-sm-3"><strong>1º dosis (2 meses)</strong>
          <input class="form-control" type="date" name="pent1">
        </div>

        <div class="col-sm-3"><strong>2º dosis (4 meses)</strong>  
          <input class="form-control" type="date" name="pent2">
        </div>

        <div class="col-sm-3"><strong>3º dosis (6 meses)</strong>  
          <input class="form-control" type="date" name="pent3">
        </div>

      </div>

      <div class="row">

        <label class="col-sm-12" for="">NEUMOCOCO:</label>
        <div class="col-sm-3"><strong>1º dosis (2 meses)</strong>
          <input class="form-control" type="date" name="neu1">
        </div>

        <div class="col-sm-3"><strong>2º dosis (4 meses)</strong>  
          <input class="form-control" type="date" name="neu2">
        </div>

        <div class="col-sm-3"><strong>3º dosis (12 meses)</strong>  
          <input class="form-control" type="date" name="neu3">
        </div>

      </div>

      <div class="row">

        <label class="col-sm-12" for="">ROTAVIRUS:</label>
        <div class="col-sm-3"><strong>1º dosis (2 meses)</strong>
          <input class="form-control" type="date" name="rot1">
        </div>

        <div class="col-sm-3"><strong>2º dosis (4 meses)</strong>  
          <input class="form-control" type="date" name="rot2">
        </div>

      </div>

      <div class="row">

        <label class="col-sm-12" for="">ROTAVIRUS:</label>
        <div class="col-sm-3"><strong>1º dosis (7 meses)</strong>
          <input class="form-control" type="date" name="rot3">
        </div>

        <div class="col-sm-3"><strong>2º dosis (8 meses)</strong>  
          <input class="form-control" type="date" name="rot4">
        </div>

      </div>

      <div class="row">

        <div class="col-sm-3"><strong>1 año</strong>
          <input class="form-control" type="date" name="ano1">
        </div>

        <div class="col-sm-3"><strong>2 años</strong>  
          <input class="form-control" type="date" name="ano2">
        </div>

        <div class="col-sm-3"><strong>3 años</strong>
          <input class="form-control" type="date" name="ano3">
        </div>

        <div class="col-sm-3"><strong>4 años</strong>  
          <input class="form-control" type="date" name="ano4">
        </div>

      </div>

      <div class="row">
        <div class="col-sm-6" for=""><label>SPR (SARAMPIÓN, PAPERA, RUBEÓLA):</label>
          <div class="col-sm-6"><strong>1º dosis (12 meses)</strong>  
            <input class="form-control" type="date" name="spr1">
          </div>
          <div class="col-sm-6"><strong>2º dosis (18 meses)</strong>  
            <input class="form-control" type="date" name="spr2">
          </div>
        </div>

        <div class="col-sm-3"><label>VARICELA:</label>
          <div class="col-sm-12"><strong>1º dosis (12 meses)</strong> 
            <input class="form-control" type="date" name="vari">
          </div>
        </div>


        <div class="col-sm-3"><label>ANTIAMARÍLICA:</label> 
          <div class="col-sm-12"><strong>(15 meses)</strong> 
          <input class="form-control" type="date" name="antia">
        </div>
        </div>
		  </div>

      <div class="row">

        <label class="col-sm-12" for="">REFUERZOS:</label>
        <div class="col-sm-6"><strong>1º REF. DPT (18 meses)</strong>
          <input class="form-control" type="date" name="ref1">
        </div>

        <div class="col-sm-6"><strong>2º REF. DPT (4 años)</strong>  
          <input class="form-control" type="date" name="ref2">
        </div>

      </div>

      <div class="row">

        <div class="col-sm-6"><strong>1º REF Antipolio (Oral 18 meses)</strong>
          <input class="form-control" type="date" name="ref3">
        </div>

        <div class="col-sm-6"><strong>2º REF Antipolio (Oral 4 años)</strong>  
          <input class="form-control" type="date" name="ref4">
        </div>

      </div>

      <div class="row">

        <label class="col-sm-12" for="">OTRAS VACUNAS:</label>
        <div class="col-sm-4">
          <input type="text" name="" placeholder="Otras vacunas" style="width: 100%">
          <input class="form-control" type="date" name="ot1">
        </div>

        <div class="col-sm-4">
          <input type="text" name="" placeholder="Otras vacunas" style="width: 100%">  
          <input class="form-control" type="date" name="ot2">
        </div>

        <div class="col-sm-4">
          <input type="text" name="" placeholder="Otras vacunas" style="width: 100%">  
          <input class="form-control" type="date" name="ot3">
        </div>

      </div>

      <div class="row">
        <label class="col-sm-12" for="">OBSERVACIONES:</label>
        <div class="col-sm-12">
          <input type="text" name="observs" placeholder="Observaciones" style="width: 100%">
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