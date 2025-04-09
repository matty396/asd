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

<h2>Editar Datos de Stock</h2>
<form class="row g-3" action="{{url('stock/'.$stock->id)}}" method="post" id="updateStock" enctype="multipart/form-data">
{{method_field("PATCH")}}
{{ csrf_field() }}
<input type="hidden" class="form-control" id="id" name="id" value="{{($stock->id !=null)?$stock->id:''}}">
<input type="hidden" class="form-control" id="mercaderia_id" name="mercaderia_id" value="{{($stock->mercaderia_id !=null)?$stock->mercaderia_id:''}}">
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
                      <input type="text" class="form-control" id="codigo" name="codigo"  value="{{($stock->codigo !=null)?$stock->codigo:''}}" autocomplete="FALSE">
                    </div>
                    <div class="col-md-7">
                      <label for="descripcion" class="form-label">Descripcion</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion" autocomplete="FALSE"  value="{{($stock->descripcion !=null)?$stock->descripcion:''}}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <label for="cantidad" class="form-label">Cantidad</label>
                      <input type="text" class="form-control" id="cantidad" name="cantidad"  value="{{($stock->cantidad !=null)?$stock->cantidad:''}}">
                    </div>
                    <div class="col-md-2">
                      <label for="cantidad_minima" class="form-label">Cantidad Minma</label>
                      <input type="text" class="form-control" id="cantidad_minima" name="cantidad_minima" value="{{($stock->cantidad_minima !=null)?$stock->cantidad_minima:''}}">
                    </div>
                    <div class="col-md-2">
                      <label for="cantidad_maxima" class="form-label">Cantidad Maxima</label>
                      <input type="text" class="form-control" id="cantidad_maxima" name="cantidad_maxima" value="{{($stock->cantidad_maxima !=null)?$stock->cantidad_maxima:''}}">
                    </div>
                    <div class="col-md-2">
                      <label for="estado" class="form-label">Estado</label>

                      <select type="text" class="form-control" id="estado" name="estado" value="{{($stock->estado !=null)?$stock->estado:''}}">
                        <option value="1">Activa</option>
                        <option value="0">Bloqueada</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label for="fecha_ingreso" class="form-label">Fecha Ingreso</label>
                      <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="{{($stock->fecha_ingreso !=null)?$stock->fecha_ingreso:''}}">
                    </div>
                  </div>
                    <br>
                    <div class="row">
                        <input type="submit" class="btn btn-primary guardar" tabindex="5" value="Guardar"></a>
                        <a href="{{ url('/stock') }}" class="btn btn-secondary" tabindex="5">Volver</a>
                    </div>
                </div>
            </div>
          </div>
        </div>
</div>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>

</form>
@stop
