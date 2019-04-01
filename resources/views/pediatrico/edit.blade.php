@extends('layouts.app')

@section('content')


<div class="col-sm-12">
	<h3>Completar Historia Pediatrica</h3>
	<form action="pediatrico/update" method="post" class="form-horizontal">
		{{ csrf_field() }}
		<div class="form-group">
			<input type="hidden" name="paciente" value="{{$pediatrico->paciente}}">
			<div class="row">
			  <label class="col-sm-3">DEJAR PENDIENTE?:</label>
			<div class="col-sm-2">
				<select id="el3" name="pendiente" value="{{$pediatrico->pendiente}}" required="true">
					<option value="0">No</option>
					<option value="1">Si</option>
				</select>
			</div> 
		</div>
           <div class="row">
            <label for="" class="col-sm-2 control-label">Motivo de Consulta</label>
			<div class="col-sm-10 control-label">	
				<input  required class="form-control" type="text" name="mot" value="{{$pediatrico->mot}}">		
			</div>
		  </div>

		  <div class="row">
			<label for="" class="col-sm-2 control-label">Tiempo de Enfermedad</label>
			<div class="col-sm-10 control-label">	
				<input  required class="form-control" type="text" name="tenf" value="{{$pediatrico->tenf}}">		
			</div>
		  </div>
		   <div class="row">
            
			<label for="" class="col-sm-2 control-label">Relato</label>
			<div class="col-sm-10 control-label">	
				<input  required class="form-control" type="textarea" name="rel" value="{{$pediatrico->rel}}">		
			</div>
		  </div>

		    <div class="row">
			<label for="" class="col-sm-2 control-label">Madre/Padre</label>
			<div class="col-sm-4 control-label">	
				<input  required class="form-control" type="text" name="mp" value="{{$pediatrico->mp}}">		
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
				<input   class="form-control" placeholder="Frecuencia Micciones" type="text" name="orin" placeholder="c 24/hrs"  value="{{$pediatrico->orin}}">
			</div>
			
			<label for="" class="col-sm-2 control-label">Frecuencia.Deposiciones</label>
			<div class="col-sm-4">	
				<input  class="form-control" placeholder="Frecuencia Deposiciones" type="text" name="hec" placeholder="c 24/hrs" value="{{$pediatrico->hec}}">
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

					<input type="text" name="ram" value="{{$pediatrico->ram}}">
					
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

					<input type="text" name="hosp" value="{{$pediatrico->hosp}}">
					
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

					<input type="text" name="cir" value="{{$pediatrico->cir}}">
					
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

					<input type="text" name="vac" value="{{$pediatrico->vac}}">
					
				</div>



			</div>

					  <div class="row">


			 <label for="" class="col-sm-3">Patològicos y Epidemiològicos</label>
				<div class="col-sm-3">
					<input  class="form-control" placeholder="Patològicos y Epidemiològicoss" type="text" name="ap" value="{{$pediatrico->ap}}">
				</div>

			</div>


			   <div class="row">
		  <div class="col-md-6">
		  	            <label for="" class="col-sm-2 control-label">EXAMEN FÌSICO:</label>
		  </div>
		  </div>


		  <div class="row">

		  <div class="col-md-2">Edad	
				<input class="form-control" type="text" name="edad" value="{{$pediatrico->edad}}">
			</div>
			<div class="col-md-2">Peso	
				<input class="form-control" type="text" name="peso" value="{{$pediatrico->peso}}">
			</div>
			<div class="col-md-2">Talla	
				<input class="form-control" type="text" name="talla" value="{{$pediatrico->talla}}">
			</div>
			<div class="col-md-2">T	
				<input class="form-control" type="text" name="pri" value="{{$pediatrico->pri}}">
			</div>
			<div class="col-md-2">PA	
				<input class="form-control" type="text" name="pa" value="{{$pediatrico->pa}}">
			</div>
			<div class="col-md-2">SAT	
				<input class="form-control" type="text" name="sat" value="{{$pediatrico->sat}}">
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
				<textarea name="hall" cols="10" rows="10" class="form-control" value="{{$pediatrico->hall}}"></textarea>
			</div>

			 <div class="row">
            	<div class="col-sm-6">
            		<strong>DIAGNÒSTICO</strong>
            	</div>

            </div>

			<div class="col-sm-12">	
				<textarea name="diag" cols="10" rows="10" class="form-control" value="{{$pediatrico->diag}}"></textarea>
			</div>

			 <div class="row">
            	<div class="col-sm-6">
            		<strong>PLAN DE TRABAJO</strong>
            	</div>

            </div>

			<div class="col-sm-12">	
				<textarea name="plan" cols="10" rows="10" class="form-control" value="{{$pediatrico->plan}}"></textarea>
			</div>

			<div class="row">
            	<div class="col-sm-6">
            		<strong>EXAMENES AUXILIARES</strong>
            	</div>

            </div>

			<div class="col-sm-12">	
				<textarea name="exa" cols="10" rows="10" class="form-control" value="{{$pediatrico->exa}}"></textarea>
			</div>

			<div class="row">
            	<div class="col-sm-6">
            		<strong>TRATAMIENTO Y EVOLUCIÒN</strong>
            	</div>

            </div>

			<div class="col-sm-12">	
				<textarea name="trat" cols="10" rows="10" class="form-control" value="{{$pediatrico->trat}}"></textarea>
			</div>
			<br>
			<label for="" class="col-sm-2 ">Pròxima Cita</label>
			<div class="col-sm-3">
				<input type="date" name="prox" class="form-control" value="{{$pediatrico->prox}}">
			</div>

								<input type="hydden" name="id" value="{{$pediatrico->id}}">

		
			
		
			<div class="col-sm-12">
				<input type="button" onclick="form.submit()" value="Registrar" class="btn btn-success" class="form-control">
			</div>
		</div>
		</div>
	</form>
	</div>
</div>
	



@endsection


