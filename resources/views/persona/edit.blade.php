@extends('layouts.plantillaBase')

@section('contenido')
<h2>Editar Datos Personales</h2>
<form class="row g-3" action="{{url('persona/'.$persona->id)}}" method="post" id="updatePersona" enctype="multipart/form-data">

{{method_field("PATCH")}}
{{ csrf_field() }}
<input type="hidden" class="form-control" id="id" name="id" value="{{($persona->id !=null)?$persona->id:''}}">
<div class="col-md-2">
    <label for="dni" class="form-label">DNI</label>
    <input type="text" class="form-control" id="dni" name="dni" value="{{($persona->dni !=null)?$persona->dni:''}}">
  </div>
  <div class="col-md-7">
    <label for="apellidos" class="form-label">Apellido</label>
    <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{($persona->apellidos !=null)?$persona->apellidos:''}}">
  </div>
  <div class="col-md-7">
    <label for="nombres" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="nombres" name="nombres" value="{{($persona->nombres !=null)?$persona->nombres:''}}">
  </div>
  <div class="col-md-2">
    <label for="email" class="form-label">Email</label>
    <input type="text" class="form-control" id="email" name="email" value="{{($persona->email !=null)?$persona->email:''}}">
  </div>
  <div class="col-md-7">
    <label for="celular" class="form-label">Celular</label>
    <input type="text" class="form-control" id="celular" name="celular" value="{{($persona->celular !=null)?$persona->celular:''}}">
  </div>
  <button type="submit"  class="btn btn-primary guardar" >GUARDAR</button>
        <a href="{{ url('/persona') }}" class="btn btn-secondary" tabindex="5">Volver</a>
        

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>

</form>
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

   

@endsection