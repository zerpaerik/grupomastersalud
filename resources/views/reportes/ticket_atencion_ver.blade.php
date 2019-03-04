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

 <div class="" style="font-size: 30px; text-align: center;">
		<p><strong>GRUPO MASTER SALUD</strong></p>
	    <p><strong>TICKET:{{ $ticket->ticket}}</strong></p>
	</div>

    <div class="" style="font-size: 30px; text-align: left;">
		<p><strong>FECHA:{{ $ticket->created_at}}</strong></p>
	</div>

	<div class="" style="font-size: 30px; text-align: left;">
		<p><strong>PACIENTE:{{ $ticket->nombres}},{{ $ticket->apellidos}}</strong></p>
	</div>

	<div class="" style="font-size: 30px; text-align: left;">
		<p><strong>DETALLE:{{ $ticket->detalle}}
		</strong></p>
	</div>

	<div class="" style="font-size: 30px; text-align: left;">
		<p><strong>ORIGEN:{{ $ticket->nompac}},{{ $ticket->apepac}}</strong></p>
	</div>

	<div class="" style="font-size: 30px; text-align: left;">
		<p><strong>MONTO: {{ $ticket->monto}}</strong></p>
	</div>

	<div class="" style="font-size: 30px; text-align: left;">
		<p><strong>PAGADO:{{ $ticket->abono}}</strong></p>
	</div>

	<div class="" style="font-size: 30px; text-align: left;">
		<p><strong>RESTA: {{ $ticket->pendiente}}</strong></p>
	</div>

	

	



</body>
</html>
