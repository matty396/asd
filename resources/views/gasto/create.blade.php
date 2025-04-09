@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    Administracion de Gastos
@stop

@section('content')

<form class="row g-3" action="{{url('gasto')}}" method="post" id="addgasto" enctype="multipart/form-data">
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
                  <div class="col-md-7">
                      <label for="descripcion" class="form-label">Descripcion</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion">
                    </div>
                    <div class="col-md-2">
                      <label for="monto" class="form-label">Monto</label>
                      <input type="text" class="form-control" id="monto" name="monto">
                    </div>
                    <div class="col-md-2">
                      <label for="fecha" class="form-label">Fecha</label>
                      <input type="date" class="form-control" id="fecha" name="fecha">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                      <label for="comentarios" class="form-label">Comentarios</label>
                      <input type="text" class="form-control" id="comentarios" name="comentarios">
                    </div>
                </div>
                          <button type="submit"  class="btn btn-primary guardar" >GUARDAR</button>
                          <a href="{{ url('/gasto') }}" class="btn btn-secondary" tabindex="5">Volver</a>
                   
                </div>
            </div>
          </div>
        </div>
</div>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>

</form>
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
