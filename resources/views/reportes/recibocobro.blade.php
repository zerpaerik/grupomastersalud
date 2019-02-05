<!DOCTYPE html>
<html lang="en">
<head>
	<title>Recibo de Cobro</title>

</head>
<body>
     <div style="width: 100%;">
        <fieldset style="border: 1px solid #000; border-radius: 5px;">
            <p><center><strong>RECIBO Nº</strong>0000{{$recibo->id}}</center></p>
            <p><center>FECHA {{$recibo->created_at}}</center></p>
        </fieldset> 
     </div>
 

    <div style="width: 100%;">
        <fieldset style="border: 1px solid #000; border-radius: 5px;">
            <center><p></p></center>
            <center><p><strong>PACIENTE:</strong>{{$recibo->nombres}},{{$recibo->apellidos}}</p></center>
            <center><p><strong>MONTO TOTAL:</strong>{{$recibo->monto}}</p></center>
            <center><p><strong>MONTO ABONADO:</strong>{{$recibo->abono_parcial}}</p></center>
            <center><p><strong>MONTO TOTAL ABONADO:</strong>{{$recibo->abono}}</p></center>s
            <center><p><strong>MONTO PENDIENTE:</strong>{{$recibo->pendiente}}</p></center>
        </fieldset> 
     </div>


	





   
  

     



 
</body>
</html>