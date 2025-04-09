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

 <!-- general form elements disabled -->
 <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Editar Gasto</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form class=""  action="{{url('gasto/'.$gasto->id)}}" method="post" id="updategasto" enctype="multipart/form-data">
                {{method_field("PATCH")}}
                {{ csrf_field() }}
                  <div class="row">
                    <div class="col-sm-7">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{($gasto->descripcion !=null)?$gasto->descripcion:''}}">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="monto" class="form-label">Monto</label>
                        $ <input style="text-align: right;" type="text" class="form-control" id="monto" name="monto" value="{{($gasto->monto !=null)?$gasto->monto:''}}">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                      <label for="fecha" class="form-label">Fecha</label>
        <input type="date" class="form-control" id="fecha" name="fecha" value="{{($gasto->fecha !=null)?$gasto->fecha:''}}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary" >GUARDAR</button>
                        <a href="{{ url('/gasto') }}" class="btn btn-secondary" tabindex="5">Volver</a>
                      </div>
                    </div>
                  </div>
                  <!-- input states -->
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- general form elements disabled -->
            

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@stop