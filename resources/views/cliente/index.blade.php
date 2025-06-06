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
    
    <h4>Administracion de Datos de Clientes</h4>
    @can('create record')
    <a href="{{ url('/cliente/create') }}" class="btn btn-success btn-sm" title="Agregar Cliente">
        <i class="fa fa-plus" aria-hidden="true"></i> Agregar
    </a>
    @endcan
    <form method="GET" action="{{ url('/cliente') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                    <th>Apellido, Nombre</th>
                    <th>DNI</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($clientes as $item)
                <tr>
                    <td>{{ $item->cliente_id }}</td>
                    <td>{{ $item->apellidos.', '.$item->nombres }}</td>
                    <td>{{ $item->dni }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->celular }}</td>
                    <td>
                        @can('edit record')
                        <a href="{{url('cliente/'.$item->cliente_id.'/edit')}}" title="Editar registro"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                        <form method="POST" action="{{ url('/cliente' . '/' . $item->cliente_id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Borrar registro" onclick="return Confirm('delete')"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $clientes->links("pagination::bootstrap-4") }}
    </div>

@stop
