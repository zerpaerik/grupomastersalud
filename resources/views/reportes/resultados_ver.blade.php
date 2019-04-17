<!DOCTYPE html>
<html lang="en">
<head>
	<title>Resultado de Informe</title>
	<link rel="stylesheet" type="text/css" href="css/pdf.css">

</head>
<body>
	<div class="" style="font-size: 35px; text-align: center; margin-bottom: -15px;">
		<img src="/var/www/html/grupomastersalud/public/img/0.png"  style="width: 30%;"/>
	</div>

	<p style="margin-left: 260px; font-size: 16px;"><strong>INFORME DE RESULTADOS</strong></p>
	<br>

	<p style="margin-left: 150px;"><strong>PACIENTE: </strong>{{ $resultados->nompac.' '.$resultados->apepac }}</p>
	<p style="margin-left: 150px;"><strong>DNI: </strong></p>
	<p style="margin-left: 150px;"><strong>EXAMEN/SERVICIO: </strong>{{ $resultados->detalle }}</p>
    <p style="margin-left: 150px;"><strong>INDICACIÓN:</strong></p>
    <p style="margin-left: 150px;"><strong>FECHA: </strong>{{ $resultados->detalle}}</p>
    <br>

    <div style="margin-right: 80px; margin-left: 15px; text-align: justify; font-size: 16px; line-height: 1.6;">{!!html_entity_decode($resultados->descripcion)!!}</div>
  


</body>
</html>