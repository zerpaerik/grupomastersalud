<!DOCTYPE html>
<html lang="en">
<head>
	<title>Recibo de Gasto</title>

</head>
<body>
     


<div class="" style="font-size: 30px; text-align: center;">
        <p><strong>GRUPO MASTER SALUD</strong></p>
    </div>

    <div class="" style="font-size: 30px; text-align: left;">
        <p><strong>RECIBO DE SALIDA DE EFECTIVO Nº:0000{{ $gastos->id}}</strong></p>
    </div>


    <div class="" style="font-size: 30px; text-align: left;">
        <p><strong>FECHA:{{ $gastos->created_at}}</strong></p>
    </div>

    <div class="" style="font-size: 30px; text-align: left;">
        <p><strong>RECIBIDO POR:{{ $gastos->nombre}}</strong></p>
    </div>

    
    <div class="" style="font-size: 30px; text-align: left;">
        <p><strong>CONCEPTO:{{ $gastos->descripcion}}
        </strong></p>
    </div>

    <div class="" style="font-size: 30px; text-align: left;">
        <p><strong> MONTO: {{ $gastos->monto}}</strong></p>
    </div>

     <div class="" style="font-size: 30px; text-align: left;">
        <p><strong> ENTREGADO POR:_________________________</strong></p>
    </div>

   


	





   
  

     



 
</body>
</html>