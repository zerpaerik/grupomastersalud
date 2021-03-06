@extends('layouts.app')

@section('content')

<body>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <div class="box-name">
          <i class="fa fa-linux"></i>
          <span>Cierres de Caja</span>

        </div>


        <div class="box-icons">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
          <a class="expand-link">
            <i class="fa fa-expand"></i>
          </a>
          <a class="close-link">
            <i class="fa fa-times"></i>
          </a>
        </div>

        <div class="no-move"></div>
        
      </div>
      {!! Form::open(['method' => 'get', 'route' => ['cierre.index']]) !!}

      <div class="row">
        <div class="col-md-2">
          <label>Fecha Inicio</label>
          <input type="date" value="{{$fecha1}}" name="fecha" style="line-height: 20px">
        </div>
        <div class="col-md-2">
          <label>Fecha Fin</label>
          <input type="date" value="{{$fecha2}}" name="fecha2" style="line-height: 20px">
        </div>
        <div class="col-md-2">
          {!! Form::submit(trans('Buscar'), array('class' => 'btn btn-info')) !!}
          {!! Form::close() !!}

        </div>
      </div>  

            <input type="hidden" name="f1" value="{{$fecha1}}">
            <input type="hidden" name="f2" value="{{$fecha2}}">


      

      <div class="row">
        <form action="/cierre-caja-create" method="post">
        {{ csrf_field() }}
        <input type="hidden" value="{{$total->monto}}" name="total">
        <input type="submit" class="btn btn-danger" value="Cerrar Turno">
      </form>
      <a href="#" class="btn btn-primary view" onclick="view(this)" data-id="{{$hoy}}">VistaPrevia</a>

    </div>

    <div class="row">
    </div>


      <div class="box-content no-padding">
        <table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-3">
          <thead>
            <tr>
               <th>Id</th>
              <th>Fecha</th>
              <th>Cierre</th>
              <th>Registrado Por:</th>
              <th>Recibos:</th>
              <th>Acciòn</th>
           
            </tr>
          </thead>
          <tbody>
                  @foreach($caja as $c)          
            <tr>
                <td>{{$c->id}}</td>
                <td>{{$c->created_at}}</td>
                @if($c->cierre_matutino)
                <td>Matutino: {{$c->cierre_matutino}}</td>
                @else
                <td>Vespertino: {{$c->cierre_vespertino}}</td>
                @endif
                <td>{{$c->name}},{{$c->lastname}}</td>
                <td>
                 
                  @if($c->cierre_matutino > 0)
                  <a target="_blank" href="{{asset('recibo_caja_ver')}}/{{$c->id}}" class="btn btn-xs btn-primary">VerM Consolidado</a>
                  <a target="_blank" href="{{asset('recibo_caja_verd')}}/{{$c->id}}" class="btn btn-xs btn-primary">VerM Detallado</a>
                  @else
                  <a target="_blank"  href="{{asset('recibo_caja_ver2')}}/{{$c->id}}/{{$fecha1}}/{{$fecha2}}" class="btn btn-xs btn-primary">VerT Consolidado</a>

                   <a target="_blank"  href="{{asset('recibo_caja_ver2d')}}/{{$c->id}}/{{$fecha1}}/{{$fecha2}}" class="btn btn-xs btn-primary">VerT Detallado</a>

                  @endif
                </td>
                <td>
                  @if(\Auth::user()->role_id <> 6)               
                  <a class="btn btn-danger" href="caja-delete-{{$c->id}}"  onclick="return confirm('¿Desea Reversar este Cierre de Caja?')">Reversar</a> 
                  @endif
                </td>
                

            

            </tr>
            
            @endforeach
          </tbody>
        

        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Resumen del Turno</h4>
              </div>
              <div class="modal-body"></div>
            </div>
          </div>
        </div>

</body>



<script src="{{url('/tema/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{url('/tema/plugins/jquery-ui/jquery-ui.min.js')}}"></script>


<style type="text/css">
    .modal-backdrop.in {
        filter: alpha(opacity=50);
        opacity: 0;
        z-index: 0;
    }

    .modal {
      top:35px;
    }
</style>

<script type="text/javascript">



function view(e){
        var id = $(e).attr('data-id');
        
        $.ajax({
            type: "GET",
            url: "/saldo/view/"+id,
            success: function (data) {
                $(".modal-body").html(data);
                $('#myModal').modal('show');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    };

// Run Datables plugin and create 3 variants of settings
function AllTables(){
  TestTable1();
  TestTable2();
  TestTable3();
  LoadSelect2Script(MakeSelect2);
}
function MakeSelect2(){
  $('select').select2();
  $('.dataTables_filter').each(function(){
    $(this).find('label input[type=text]').attr('placeholder', 'Search');
  });
}
$(document).ready(function() {
  // Load Datatables and run plugin on tables 
  LoadDataTablesScripts(AllTables);
  // Add Drag-n-Drop feature
  WinMove();
});
</script>
@endsection
