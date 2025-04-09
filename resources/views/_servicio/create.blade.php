@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  Agregar Servicio
@stop

@section('content')
<div id="site-content">
<main class="main-content">
<form class="row g-3" action="{{url('servicio')}}" method="post" id="addServicio" enctype="multipart/form-data">
  {{ csrf_field() }}
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">

              <!-- /.card-header -->
                <div class="card-body">
                  <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">  
                  </div>
                  <div class="form-group">
                    <label for="monto" class="form-label">Monto</label>
                    <input type="text" class="form-control" id="monto" name="monto">
                  </div>
                  <div class="form-group">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <input type="text" class="form-control" id="observaciones" name="observaciones">
                  </div>
                     
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save"/>
                  <!--<button type="submit"  class="btn btn-primary guardar" >GUARDAR</button>-->
                  <a href="{{ url('/servicio') }}" class="btn btn-secondary" tabindex="5">Volver</a>
                </div>
            </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>
    </div>
  </div>
</form>
</div>
</div>
@stop