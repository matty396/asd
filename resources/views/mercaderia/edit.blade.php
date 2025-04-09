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

<h2>Editar Datos de Mercaderias</h2>
<form class="row g-3" action="{{url('mercaderia/'.$mercaderia->id)}}" method="post" id="updateMercaderia" enctype="multipart/form-data">
{{method_field("PATCH")}}
{{ csrf_field() }}
<input type="hidden" class="form-control" id="id" name="id" value="{{($mercaderia->id !=null)?$mercaderia->id:''}}">
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
                      <input type="text" class="form-control" id="codigo" name="codigo"  value="{{($mercaderia->codigo !=null)?$mercaderia->codigo:''}}">
                    </div>
                    <div class="col-md-7">
                      <label for="descripcion" class="form-label">Descripcion</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion"  value="{{($mercaderia->descripcion !=null)?$mercaderia->descripcion:''}}">
                    </div>
                  </div>
                  <div class="row" style="display: none;">
                    <div class="col-md-3">
                      <label for="alto" class="form-label">Alto</label>
                      <input type="text" class="form-control" id="alto" name="alto" value="{{($mercaderia->alto !=null)?$mercaderia->alto:''}}">
                    </div>
                    <div class="col-md-3">
                      <label for="ancho" class="form-label">Ancho</label>
                      <input type="text" class="form-control" id="ancho" name="ancho"  value="{{($mercaderia->ancho !=null)?$mercaderia->ancho:''}}">
                    </div>
                    <div class="col-md-3">
                      <label for="profundidad" class="form-label">Profundidad</label>
                      <input type="text" class="form-control" id="profundidad" name="profundidad" value="{{($mercaderia->profundidad !=null)?$mercaderia->profundidad:''}}">
                    </div>
                    <div class="col-md-3">
                      <label for="unidad_medida" class="form-label">Unidad Medida (mm-cm-m)</label>
                      <input type="text" class="form-control" id="unidad_medida" name="unidad_medida"  value="{{($mercaderia->unidad_medida !=null)?$mercaderia->unidad_medida:''}}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label for="peso" class="form-label">Peso</label>
                      <input type="text" class="form-control" id="peso" name="peso" value="{{($mercaderia->peso !=null)?$mercaderia->peso:''}}">
                    </div>
                    <div class="col-md-3">
                      <label for="unidad_peso" class="form-label">Unidad Peso (mg-g-kg)</label>
                      <input type="text" class="form-control" id="unidad_peso" name="unidad_peso" value="{{($mercaderia->unidad_peso !=null)?$mercaderia->unidad_peso:''}}">
                    </div>
                    <div class="col-md-3">
                      <label for="precio" class="form-label">Precio</label>
                      <input type="text" class="form-control" id="precio" name="precio" value="{{($mercaderia->precio !=null)?$mercaderia->precio:''}}">
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
