@extends('layouts.app')

@section('content')
<br>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-users"></i>
					<span><strong>Editar Botica</strong></span>
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
				<form class="form-horizontal" role="form" method="post" action="botica/edit">
					{{ csrf_field() }}
					<div class="form-group">
						<label class="col-sm-1 control-label">Nombre</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="nombre" placeholder="Nombre" data-toggle="tooltip" data-placement="bottom" value="{{$nombre}}" title="Nombre">
						</div>

						<label class="col-sm-1 control-label">Responsable</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="responsable" placeholder="direccion" data-toggle="tooltip" data-placement="bottom" value="{{$responsable}}" title="direccion">
						</div>

						<label class="col-sm-1 control-label">Direcciòn</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="direccion" placeholder="referencia" data-toggle="tooltip" data-placement="bottom" value="{{$direccion}}" title="direccion">
						</div>
			

						<input type="hidden" name="id" value="{{$id}}">

						<div class="col-sm-8">
							<input type="button" onclick="form.submit()" class="col-sm-2 btn btn-primary" value="Editar">
							<a href="{{route('botica.index')}}" class="col-sm-2 btn btn-danger">Volver</a>
						</div>
					</div>			
				</form>	
			</div>
		</div>
	</div>
</div>
@endsection