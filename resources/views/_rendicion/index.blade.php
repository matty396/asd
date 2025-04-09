@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h4>Administracion de Rendiciones</h4>
@stop

@section('content')
    <div class="container">
    @if(Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
        {{  Session::get('mensaje')}}
        </div>
    @endif
    
   
    <a href="{{ url('/rendicion/create') }}" class="btn btn-success btn-sm" title="Agregar rendicion">
        <i class="fa fa-plus" aria-hidden="true"></i> Agregar
    </a>
    <form method="GET" action="{{ url('/rendicion') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
        <span style="margin-right: 1.2em;">
       
        </span>
        <span class="input-group-append"  style="float:right">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                
                    <button class="btn btn-secondary" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                
            </div>
        </span>
    </form>

    <br/>
    <br/>
    <div class="table-responsive">
        <table class="table table-light table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Fecha Proceso</th>
                    <th>Fecha Envio</th>
                    <th>Nro Lote</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($rendiciones as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->fecha_proceso }}</td>
                    <td>{{ $item->fecha_envio }}</td>
                    <td>{{ $item->nro_lote }}</td>
                    <td>
                    <a href="{{url('rendicionesDetalle/')}}" title="Ver Detalle"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ver</button></a>
                        <a href="{{url('servicio/'.$item->id.'/edit')}}" title="Editar registro"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                        <form method="POST" action="{{ url('/servicio' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Borrar registro" onclick="return Confirm('delete')"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $rendiciones->links("pagination::bootstrap-4") }}
    </div>

@stop
