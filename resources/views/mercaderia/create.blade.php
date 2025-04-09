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

    <h4>Administracion de Datos de Mercaderia</h4>
    <a href="{{ url('/mercaderia/create') }}" class="btn btn-success btn-sm" title="Agregar Mercaderia">
        <i class="fa fa-plus" aria-hidden="true"></i> Agregar
    </a>

<form class="row g-3" action="{{url('mercaderia')}}" method="post" id="addMercaderia" enctype="multipart/form-data">
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
                    <div class="col-md-2">
                      <label for="codigo" class="form-label">Codigo</label>
                      <input type="text" class="form-control" id="codigo" name="codigo">
                    </div>
                    <div class="col-md-7">
                      <label for="descripcion" class="form-label">Descripcion</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion">
                    </div>
                  </div>
                  <div class="row" style="display: none;">
                    <div class="col-md-3">
                      <label for="alto" class="form-label">Alto</label>
                      <input type="hidden" class="form-control" id="alto" name="alto">
                    </div>
                    <div class="col-md-3">
                      <label for="ancho" class="form-label">Ancho</label>
                      <input type="hidden" class="form-control" id="ancho" name="ancho">
                    </div>
                    <div class="col-md-3">
                      <label for="profundidad" class="form-label">Profundidad</label>
                      <input type="hidden" class="form-control" id="profundidad" name="profundidad">
                    </div>
                    <div class="col-md-3">
                      <label for="unidad_medida" class="form-label">Unidad Medida (mm-cm-m)</label>
                      <input type="hidden" class="form-control" id="unidad_medida" name="unidad_medida">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label for="peso" class="form-label">Peso</label>
                      <input type="text" class="form-control" id="peso" name="peso">
                    </div>
                    <div class="col-md-2">
                      <label for="unidad_peso" class="form-label">Unidad Peso (g-kg)</label>
                      <input type="text" class="form-control" id="unidad_peso" name="unidad_peso" value="KG">
                    </div>
                    <div class="col-md-2">
                      <label for="precio" class="form-label">Precio</label>
                      <input type="text" class="form-control" id="precio" name="precio" value="">
                    </div>
                  </div>
                    <br>
                    <div>
                          <button type="submit"  class="btn btn-primary guardar" >GUARDAR</button>
                          <a href="{{ url('/mercaderia') }}" class="btn btn-secondary" tabindex="5">Volver</a>
                    </div>
                </div>
            </div>
          </div>
        </div>
</div>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>

</form>
@stop
