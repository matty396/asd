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
    
    <h4>Administracion de Compras</h4>
    @can('create record')
    <a href="{{ url('compra/create') }}" class="btn btn-success btn-sm" title="Nuevo Comprobante">
        <i class="fa fa-plus" aria-hidden="true"></i> Nueva compra
    </a>
    @endcan
    <form method="GET" action="{{ url('/compra') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                    <th>proveedor</th>
                    <th>Total</th>
                    <th>Pago</th>
                    <th>Saldo</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($compras as $item)
                <tr>
                    <td> {{ $item->id }}</td>
                    <td>{{ $item->proveedor }}</td>
                    <td>$ {{ number_format($item->total,2,",",".") }}</td>
                    <td>$ {{ number_format($item->pago),2,",","." }}</td>
                    <div style="visibility: hidden;">{{$saldo = $item->total - $item->pago}}</div>
                    <td>$ {{ number_format($saldo,2,",",".")}}</td>
                    <td>{{ $item->fecha}}</td>
                    <td>
                        @can('edit record')
                        <a href="{{url('compra/'.$item->id.'/edit')}}" title="Editar registro"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>
                        <form method="POST" action="{{ url('/compra' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
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
        {{ $compras->links("pagination::bootstrap-4") }}
    </div>

@stop
