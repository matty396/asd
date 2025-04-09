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

<h2>Editar Datos de Proveedores</h2>
<form class="row g-3" action="{{url('proveedor/'.$proveedor->id)}}" method="post" id="updateProveedor" enctype="multipart/form-data">

{{method_field("PATCH")}}
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
                    <div class="col-md-5">
                      <label for="cuit" class="form-label">CUIT</label>
                      <input type="text" class="form-control" id="cuit" name="cuit" value="{{($proveedor->cuit !=null)?$proveedor->cuit:''}}">
                    </div>
                    <div class="col-md-5">
                      <label for="nombre_fantasia" class="form-label">Nombre de Fantasia</label>
                      <input type="text" class="form-control" id="nombre_fantasia" name="nombre_fantasia" value="{{($proveedor->nombre_fantasia !=null)?$proveedor->nombre_fantasia:''}}">
                    </div>
                  </div>
              <div class="row">
                  <div class="col-5">
                    <label for="domicilio" class="form-label">Domicilio</label>
                    <input type="text" class="form-control" id="domicilio" name="domicilio" value="{{($proveedor->domicilio !=null)?$proveedor->domicilio:''}}">
                  </div>
                  <div class="col-2">
                    <label for="nro" class="form-label">Nro</label>
                    <input type="text" class="form-control" id="nro" name="nro"  value="{{($proveedor->nro !=null)?$proveedor->nro:''}}">
                  </div>
                  <div class="col-2">
                    <label for="piso" class="form-label">Piso</label>
                    <input type="text" class="form-control" id="piso" name="piso" value="{{($proveedor->piso !=null)?$proveedor->piso:''}}">
                  </div>
                  <div class="col-2">
                    <label for="dpto" class="form-label">Dpto</label>
                    <input type="text" class="form-control" id="dpto" name="dpto" value="{{($proveedor->dpto !=null)?$proveedor->dpto:''}}">
                  </div>
                </div>
              <div class="row">
                <div class="col-md-4">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" value="{{($proveedor->email !=null)?$proveedor->email:''}}">
                </div>
                <div class="col-md-4">
                  <label for="celular" class="form-label">Celular</label>
                  <input type="text" class="form-control" id="celular" name="celular" value="{{($proveedor->celular !=null)?$proveedor->celular:''}}">
                </div>
              </div>
             <div class="row mt-2">
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
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@stop