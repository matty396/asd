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

<h2>Editar Datos de Clientes</h2>
<form class="row g-3" action="{{url('cliente/'.$cliente->cliente_id)}}" method="post" id="updateCliente" enctype="multipart/form-data">

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
            <input type="hidden" class="form-control" id="persona_id" name="persona_id" value="{{($cliente->persona_id !=null)?$cliente->persona_id:''}}">
            <div class="row">
              <div class="col-md-2">
                  <label for="dni" class="form-label">DNI</label>
                  <input type="text" class="form-control" id="dni" name="dni" value="{{($cliente->dni !=null)?$cliente->dni:''}}">
                </div>
                <div class="col-md-5">
                  <label for="nombres" class="form-label">Nombre</label>
                  <input type="text" class="form-control" id="nombres" name="nombres" value="{{($cliente->nombres !=null)?$cliente->nombres:''}}">
                </div>
                <div class="col-md-5">
                  <label for="apellidos" class="form-label">Apellido</label>
                  <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{($cliente->apellidos !=null)?$cliente->apellidos:''}}">
                </div>
              </div>
              <div class="row">
                  <div class="col-5">
                    <label for="domicilio" class="form-label">Domicilio</label>
                    <input type="text" class="form-control" id="domicilio" name="domicilio" value="{{($cliente->domicilio !=null)?$cliente->domicilio:''}}">
                  </div>
                  <div class="col-2">
                    <label for="nro" class="form-label">Nro</label>
                    <input type="text" class="form-control" id="nro" name="nro"  value="{{($cliente->nro !=null)?$cliente->nro:''}}">
                  </div>
                  <div class="col-2">
                    <label for="piso" class="form-label">Piso</label>
                    <input type="text" class="form-control" id="piso" name="piso" value="{{($cliente->piso !=null)?$cliente->piso:''}}">
                  </div>
                  <div class="col-2">
                    <label for="dpto" class="form-label">Dpto</label>
                    <input type="text" class="form-control" id="dpto" name="dpto" value="{{($cliente->dpto !=null)?$cliente->dpto:''}}">
                  </div>
                </div>
              <div class="row">
                <div class="col-md-3">
                    <label for="fecha_nacimiento" class="form-label">F. Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{($cliente->fecha_nacimiento !=null)?$cliente->fecha_nacimiento:''}}">
                  </div> 
                <div class="col-md-4">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" value="{{($cliente->email !=null)?$cliente->email:''}}">
                </div>
                <div class="col-md-4">
                  <label for="celular" class="form-label">Celular</label>
                  <input type="text" class="form-control" id="celular" name="celular" value="{{($cliente->celular !=null)?$cliente->celular:''}}">
                </div>
              </div>
             <div class="row mt-2">
                  <button type="submit"  class="btn btn-primary guardar" >GUARDAR</button>
                  <a href="{{ url('/cliente') }}" class="btn btn-secondary" tabindex="5">Volver</a>
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