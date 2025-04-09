@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    Administracion de datos personales
@stop

@section('content')

<form class="row g-3" action="{{url('persona')}}" method="post" id="addPersona" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">

              <!-- /.card-header -->
                <div class="card-body"> 
                  <div class="col-md-2">
                      <label for="dni" class="form-label">DNI</label>
                      <input type="text" class="form-control" id="dni" name="dni">
                    </div>
                    <div class="col-md-7">
                      <label for="apellidos" class="form-label">Apellido</label>
                      <input type="text" class="form-control" id="apellidos" name="apellidos">
                    </div>
                    <div class="col-md-7">
                      <label for="nombres" class="form-label">Nombre</label>
                      <input type="text" class="form-control" id="nombres" name="nombres">
                    </div>
                    <div class="col-md-2">
                      <label for="parsubcod" class="form-label">Email</label>
                      <input type="text" class="form-control" id="parsubcod" name="parsubcod">
                    </div>
                    <div class="col-md-7">
                      <label for="celular" class="form-label">Celular</label>
                      <input type="text" class="form-control" id="celular" name="celular">
                    </div>
                    <br>
                    <div>
                          <button type="submit"  class="btn btn-primary guardar" >GUARDAR</button>
                          <a href="{{ url('/persona') }}" class="btn btn-secondary" tabindex="5">Volver</a>
                    </div>
                </div>
            </div>
          </div>
        </div>
</div>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>

</form>
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

      $(".guardar").click(function (e) {
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
            
      });
</script>

   

