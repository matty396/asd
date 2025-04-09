@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  <h4>Agregar Rendicion</h4>
@stop

@section('content')
<div id="site-content">
<main class="main-content">
<form class="row g-3" action="{{url('rendicion')}}" method="post" id="addRendicion" enctype="multipart/form-data">
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
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <input type="text" class="form-control" id="observaciones" name="observaciones">
                      </div>
                      <div class="form-group">
                        <label for="archivoRendicion">Subir Archivo de Rendicion (.ZIP)</label>
                        <div class="input-group">
                        <div class="custom-file"> 
                          <div class="form-group">
                            <form action="{{ url('/rendicion') }}" method="post" enctype="multipart/form-data">
                                <input type="file" name="file" />
                                <input type="submit" class="btn btn-primary" name="archivoRendicion" value="Subir">
                            </form></div></div>
                          </div>
                        </div>
                      </div>   
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save"/>
                  <!--<button type="submit"  class="btn btn-primary guardar" >GUARDAR</button>-->
                  <a href="{{ url('/rendicion') }}" class="btn btn-secondary" tabindex="5">Volver</a>
                </div>
            </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"/>
    </div>
  </div>
</form>
  <div class="row">
      <!-- CSV file upload form -->
      <div class="col-md-12" id="importFrm" style="">
          
      </div>
  </div>
</div>
</div>

@stop