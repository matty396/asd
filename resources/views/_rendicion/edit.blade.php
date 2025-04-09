@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    Editar Datos de Servicio
@stop

@section('content')
<div id="site-content">
    <main class="main-content">
        <form class="row g-3" action="{{url('servicio/'.$servicio->id)}}" method="post" id="updateServicio" enctype="multipart/form-data">
            <div class="container-fluid">
                <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">

                    <!-- /.card-header -->
                        <div class="card-body">
                            {{method_field("PATCH")}}
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" id="id" name="id" value="{{($servicio->id !=null)?$servicio->id:''}}">
                            <div class="col-md-2">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{($servicio->nombre !=null)?$servicio->nombre:''}}">
                            </div>
                            <div class="col-md-7">
                                <label for="monto" class="form-label">Monto</label>
                                <input type="text" class="form-control" id="monto" name="monto" value="{{($servicio->monto !=null)?$servicio->monto:''}}">
                            </div>
                            <div class="col-md-7">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <input type="text" class="form-control" id="observaciones" name="observaciones" value="{{($servicio->observaciones !=null)?$servicio->observaciones:''}}">
                            </div>
                            <br>
                            <button type="submit"  class="btn btn-primary guardar" >GUARDAR</button>
                                    <a href="{{ url('/servicio/update') }}" class="btn btn-secondary" tabindex="5">Volver</a>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>

        </form>
    </main>
</div>
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>-->
<!--<script src="{{ asset('/js/ajax.js') }}" defer></script>-->
<script type='text/javascript'>
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   $(document).ready(function(){

      // Search by socioNro
      $("#socio_nro").keyup(function (e) {
            var socioNro = Number($('#socio_nro').val().trim());
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
           // AJAX POST request
           if (e.which == 13) {
            $.ajax({
                url:  '{{url("archivoDeudaDetalle/getSocio")}}',
                type: 'post',
                data: {socioNro: socioNro},
                dataType: 'json',
                success: function(response){
                    $("#dni").val(response.dni);
                    $("#apellidoNombre").val(response.apellidos+", "+response.nombres);

                }
            });
        }
         

      });
        // Search by dni
        $("#dni").keyup(function (e) {
            var dni = $('#dni').val().trim();
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
           // AJAX POST request
           if (e.which == 13) {
            $.ajax({
                url: '{{url("archivoDeudaDetalle/getSociopordni")}}',
                type: 'post',
                data: {dni: dni},
                dataType: 'json',
                success: function(response){
                    $("#socioNro").val(response.socio_nro);
                    $("#apellidoNombre").val(response.apellidos+", "+response.nombres);

                }
            });
        }
      });
    });

            // Search by dni
    $("#parsubcod").keyup(function (e) {
            var parsubcod = $('#parsubcod').val().trim();
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
           // AJAX POST request
           if (e.which == 13) {
            $.ajax({
                url: '{{url("servicio/getServicioPorCod")}}',
                type: 'post',
                data: {parsubcod: parsubcod},
                dataType: 'json',
                success: function(response){
                    $("#servicioNombre").val(response.concepto);

                }
            });
        }
         

      });

      /*$(".guardar").click(function (e) {
        var data = $("#addArchiviDeudaDetalle").serialize();
        
        $.ajax({
                url: '{{url("archivoDeudaDetalle")}}',
                type: 'post',
                data: data  ,
                dataType: 'json',
                success: function(response){
                    //$("#servicioNombre").val(response.concepto);
                    $('.detalles').DataTable().ajax.reload();
                }
            });
            
      });*/
</script>

   

