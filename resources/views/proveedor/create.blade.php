@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h5>Administracion de datos de Proveedores</h5>
@stop

@section('content')

<form class="row g-3" action="{{url('proveedor')}}" method="post" id="addproveedor" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">

              <!-- /.card-header -->
                <div class="card-body"> 
                  <div class="row">
                    <div class="col-5">
                      <label for="cuit" class="form-label">cuit</label>
                      <input type="text" class="form-control" id="cuit" name="cuit">
                    </div>
                    <div class="col-5">
                      <label for="nombre_fantasia" class="form-label">Nombre de Fantasia</label>
                      <input type="text" class="form-control" id="nombre_fantasia" name="nombre_fantasia">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5">
                      <label for="domicilio" class="form-label">Domicilio</label>
                      <input type="text" class="form-control" id="domicilio" name="domicilio">
                    </div>
                    <div class="col-2">
                      <label for="nro" class="form-label">Nro</label>
                      <input type="text" class="form-control" id="nro" name="nro">
                    </div>
                    <div class="col-2">
                      <label for="piso" class="form-label">Piso</label>
                      <input type="text" class="form-control" id="piso" name="piso">
                    </div>
                    <div class="col-2">
                      <label for="dpto" class="form-label">Dpto</label>
                      <input type="text" class="form-control" id="dpto" name="dpto">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label for="celular" class="form-label">Celular</label>
                      <input type="text" class="form-control" id="celular" name="celular">
                    </div> 
                    <div class="col-md-4">
                      <label for="email" class="form-label">E-mail</label>
                      <input type="text" class="form-control" id="email" name="email">
                    </div>
                  </div>
                  <div class="form-group mt-2">
                      <button type="submit"  class="btn btn-primary guardar" >GUARDAR</button>
                      <a href="{{ url('/proveedor') }}" class="btn btn-secondary" tabindex="5">Volver</a>
        
                  </div>
 
                </div>
            </div>
          </div>
        </div>
</div>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>

</form>
@stop


   

