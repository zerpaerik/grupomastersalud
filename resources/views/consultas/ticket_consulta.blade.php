<style>
	.paciente {

margin-left: 100px;
margin-top: 45px;
margin-bottom: 2px;
}
.fecha {

margin-left: 100px;
margin-top:-30px;


}
.servicios {

margin-left: 50px;
margin-top:40px;

}
.analisis {

margin-left: 50px;
margin-top:-30px;

}

.acuenta {

margin-left: 50px;
margin-top:40px;
margin-bottom: 1px;

}

.pendiente {

margin-left: 180px;
margin-top:-50px;

}

.origen {

margin-left: 50px;
margin-top:-60px;

}

.total {

margin-left: 410px;
margin-top: -20px;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Ticket de Atenciòn</title>
</head>
<body>


    <div class="" style="font-size: 40px; text-align: center; margin-bottom: 100px;">
		<p><strong>GRUPO MASTER SALUD</strong></p>
	</div>

    <div class="" style="font-size: 40px; text-align: left; margin-bottom: 100px;">
		<p><strong>FECHA:{{ $paciente->date}}</strong></p>
	</div>

	<div class="" style="font-size: 40px; text-align: left; margin-bottom: 100px;">
		<p><strong>PACIENTE:{{ $paciente->nombres}},{{ $paciente->apellidos}}</strong></p>
	</div>

	
	<div class="" style="font-size: 40px; text-align: left;margin-bottom: 100px;">
		<p><strong>ESPECIALISTA:{{ $paciente->nombrePro}} {{ $paciente->apellidoPro}}
		</strong></p>
	</div>

	<div class="" style="font-size: 40px; text-align: left;margin-bottom: 100px;">
		<p><strong>CONSULTA:{{ $paciente->consulta}} 
		</strong></p>
	</div>

	<div class="" style="font-size: 40px; text-align: left;">
		<p><strong> MONTO: {{ $paciente->monto}}</strong></p>
	</div>



	
</body>
</html>

</body>
</html>
