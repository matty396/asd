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

<h2>Editar Compra+</h2>

<div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- /.card-header -->
                <div class="card-body"> 
                  <form class="row g-3" action="{{url('compraDetalle')}}" method="post" id="addcompra" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-md-3">
                        <label for="comprobante" class="form-label">Comprobante</label>
                        <input type="text" class="form-control" id="comprobante" name="comprobante" value="{{isset($comprobante_id)?$comprobante_id:''}}" autocomplete="FALSE" readonly>
                      </div>
                      <div class="col-md-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" autocomplete="FALSE" value="{{date('Y-m-d')}}">
                      </div>
                      <div class="col-md-6">
                        <label for="proveedor" class="form-label">Proveedor</label>
                        <input type="text" class="form-control" id="proveedor" name="proveedor">
                      </div>
                    </div>
                  </form>
                  <!-------------------------------------------->
                  <form class="row g-3" action="{{url('compraDetalle')}}" method="post" id="addcompraDetalle" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="compra_id" id="compra_id" value="{{isset($compra)?$compra->id:''}}">
                    <input type="hidden" name="proveedor_id" id="proveedor_id" value="{{isset($proveedor_id)?$proveedor_id:''}}">

                    <div class="row">
                      <div class="col-md-2">
                        <label for="codigo" class="form-label">Codigo</label>
                        <input type="text" class="form-control" id="codigo" name="codigo">
                      </div>
                      <div class="col-md-4">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion">
                      </div>
                      <div class="col-md-2">
                        <label for="cantidad" class="form-label">Cant.</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad">
                      </div>
                      <div class="col-md-2">
                        <label for="precio_unitario" class="form-label">P. U.</label>
                        <input type="text" class="form-control" id="precio_unitario" name="precio_unitario">
                      </div>
                      <div class="col-md-2">
                        <label for="subtotal" class="form-label">Subtotal</label>
                        <input type="text" class="form-control" id="subtotal" name="subtotal" value="" readonly>
                      </div>
                      
                    </div>
                    <br>
                    <div class="row">
                        <input type="button" class="btn btn-primary guardarYCopiar" tabindex="5" value="Guardar y Seguir"></a>
                        <input type="button" class="btn btn-primary guardarYSalir" tabindex="5" value="Guardar y Salir"></a>
                        <a href="{{ url('/compra') }}" class="btn btn-secondary" tabindex="5">Volver</a>
                    </div>
                  </form>
                  <!----------------------------->
                  <div id="card-tabla">
                    <table class="table table-striped mt-4 detalles" id="tabla">
                        <thead>
                            <tr>
                                <th scope="col">Codigo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">P.U.</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach($compraDetalle as $value)
                            <tr>
                                <td>{{$value->codigo}}</td>
                                <td>{{$value->descripcion}}</td>
                                <td>{{$value->cantidad}}</td>
                                <td>{{$value->precio_unitario}}</td>
                                <td>{{$value->subtotal}}</td>
                                <td>
                                    <a class="btn btn-danger" >Borrar</a>
                                </td>
                            </tr>
                            @endforeach        
                        </tbody>
                    </table>
                    {{ $compraDetalle->links("pagination::bootstrap-4") }}
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>
                  </div>    
                </div>
            </div>
          </div>
        </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="{{asset('vendor/Jquery-ui/jquery-ui.min.css')}}">
<script src="{{asset('vendor/Jquery-ui/jquery-ui.min.js')}}"></script>
<script type='text/javascript'>
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   $(document).ready(function(){

      // Search by socioNro
      $("#codigo").blur(function (e) {//alert($('meta[name="csrf-token"]').attr('content'));
            var codigo = $('#codigo').val().trim();
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
           // AJAX POST request
           //if (e.which == 13) {
            $.ajax({
                url:  '{{url("mercaderia/getByCodigo")}}',
                type: 'post',
                data: {codigo: codigo},
                dataType: 'json',
                success: function(response){
                    $("#mercaderia_id").val(response.mercaderia_id);
                    $("#descripcion").val(response.descripcion);
                    $("#cantidad").focus();
                }
            });
        //}

      });

      $(".guardarYCopiar").click(function (e) {
        var data = $("#addcompraDetalle").serialize();
       // TREMENDOOOOOOOO a ver que se puede hacer para que no cree el comprobante antes de entrar
        //fijate si en el serialize podes recibirlo como request y leer el compra id
        $.ajax({
                url: '{{url("compraDetalle")}}',
                type: 'post',
                data: data  ,
                dataType: 'json',
                success: function(response){
                    //$("#servicioNombre").val(response.concepto);
                    //$('.detalles').DataTable().ajax.reload();
                    $('#compra_id').val(response.compra_id);
                    $('#comprobante').val(response.compra_id);
                    $('#card-tabla').load(document.URL+  ' #card-tabla');

                }
            });
            
      });

      $(".guardarYSalir").click(function (e) {
        var data = $("#addcompraDetalle").serialize();
        
        $.ajax({
                url: '{{url("compraDetalle")}}',
                type: 'post',
                data: data  ,
                dataType: 'json',
                success: function(response){
                    //$("#servicioNombre").val(response.concepto);
                    //$('.detalles').DataTable().ajax.reload();
                    $('#card-tabla').load(document.URL +  ' #card-tabla');
                }
            });
            
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
                success: function(response){
                    $("#mercaderia_id").val(response.id);
                    $("#codigo").val(response.codigo);
                }
            });
        
          }
      );

      $( "#cliente" ).autocomplete({
        source:function(request, response){
            $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({ 
            url: "{{url('cliente/getClientes')}}",
            type:'post',
            data:{search:$('#cliente').val().trim()},
            dataType: 'json',
            success: function (data) {
                    response(data);
                }
            })
          },
          select: function(event, ui) {
	            $( "#cliente_id" ).val(ui.item.id);
              $( "#cliente" ).val(ui.item.value);
	        }

      });
      
      
      

      $("#precio_unitario").blur(function (e) {
        $("#subtotal").val($("#cantidad").val()*$("#precio_unitario").val());
      });
</script>
@stop
