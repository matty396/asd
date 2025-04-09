@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="container">
    @if(Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
        {{  Session::get('mensaje')}}
        </div>
    @endif

    <h4>Cargar Stock</h4>


<form class="row g-3" action="{{url('stock')}}" method="post" id="addstock" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="mercaderia_id" id="mercaderia_id" value="">
<div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">

              <!-- /.card-header -->
                <div class="card-body"> 
                  <div class="row">
                    <div class="col-md-2">
                      <label for="codigo" class="form-label">Codigo</label>
                      <input type="text" class="form-control" id="codigo" name="codigo" value="" autocomplete="FALSE">
                    </div>
                    <div class="col-md-7">
                      <label for="descripcion" class="form-label">Descripcion</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion" autocomplete="FALSE">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <label for="cantidad" class="form-label">Cantidad</label>
                      <input type="text" class="form-control" id="cantidad" name="cantidad">
                    </div>
                    <div class="col-md-2">
                      <label for="cantidad_minima" class="form-label">Cantidad Minma</label>
                      <input type="text" class="form-control" id="cantidad_minima" name="cantidad_minima">
                    </div>
                    <div class="col-md-2">
                      <label for="cantidad_maxima" class="form-label">Cantidad Maxima</label>
                      <input type="text" class="form-control" id="cantidad_maxima" name="cantidad_maxima">
                    </div>
                    <div class="col-md-2">
                      <label for="estado" class="form-label">Estado</label>

                      <select type="text" class="form-control" id="estado" name="estado">
                        <option value="1">Activa</option>
                        <option value="0">Bloqueada</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="fecha_ingreso" class="form-label">Fecha Ingreso</label>
                      <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso">
                    </div>
                  </div>
                    <br>
                    <div class="row">
                        <input type="button" class="btn btn-primary guardar" tabindex="5" value="Guardar"></a>
                        <a href="{{ url('/stock') }}" class="btn btn-secondary" tabindex="5">Volver</a>
                    </div>
                </div>
            </div>
          </div>
        </div>
</div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="http://localhost/vendor/Jquery-ui/jquery-ui.min.css">
<script src="http://localhost/vendor/Jquery-ui/jquery-ui.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>-->
<!--<script src="http://localhost/js/ajax.js" defer></script>-->
<script type='text/javascript'>
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   $(document).ready(function(){

      // Search by socioNro
      $("#codigo").keyup(function (e) {
            var codigo = $('#codigo').val().trim();
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
           // AJAX POST request
           if (e.which == 13) {
            $.ajax({
                url:  '{{url("mercaderia/getByCodigo")}}',
                type: 'post',
                data: {codigo: codigo},
                dataType: 'json',
                success: function(response){alert(JSON.stringify(response));
                    $("#mercaderia_id").val(response.mercaderia_id);
                    $("#descripcion").val(response.descripcion);
                }
            });
        }

      });

      
    });

    $( "#descripcion" ).autocomplete({
      
        source:function(request, response){
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({ 
            url: "{{url('mercaderia/getMercaderias')}}",
            type:'post',
            data:{search:$('#descripcion').val().trim()},
            dataType: 'json',
            success: function (data) {
                    response(data);
                }
            })
          }
      });

      $( "#descripcion" ).on(
          "autocompletechange",
          function( event, ui ) {
            
            var descripcion = $('#descripcion').val().trim();
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: '{{url("mercaderia/getMercaderiaCodigo")}}',
                type: 'post',
                data: {descripcion: descripcion},
                dataType: 'json',
                success: function(response){alert(JSON.stringify(response));
                    $("#mercaderia_id").val(response.id);
                    $("#codigo").val(response.codigo);
                }
            });
        
          }
      );




      $(".guardar").click(function (e) {
        $("#addstock").submit();
        /*var data = $("#addstock").serialize();
        
        $.ajax({
                url: '{{url("stock")}}',
                type: 'post',
                data: data  ,
                dataType: 'json',
                success: function(response){
                    //$("#servicioNombre").val(response.concepto);
                    $('.detalles').DataTable().ajax.reload();
                }
            });*/
            
      });
</script>
@stop
