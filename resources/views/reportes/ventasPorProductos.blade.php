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
    
    <h4>Administracion de Ventas+</h4>
    <a href="{{ url('venta/create') }}" class="btn btn-success btn-sm" title="Nuevo Comprobante">
        <i class="fa fa-plus" aria-hidden="true"></i> Exportar
    </a>
    <form class="row g-3" action="{{url('ventasPorProductos')}}" method="post" id="filtrosPersonales" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <label for="filtro" class="form-label">Filtros</label>
                        <div class="input-group">
                            <div class="row">
                                <div class="col-xs-3">
                                    <input id="fecha_desde" name="fecha_desde" type="date" class="form-control rounded" placeholder="Fecha desde" aria-label="Search" aria-describedby="search-addon"  value="{{isset($filtro_fecha_vto)?$filtro_fecha_vto:''}}"/>
                                </div>
                                <div class="col-xs-3">
                                    <input id="fecha_hasta" name="fecha_hasta" type="date" class="form-control rounded" placeholder="Fecha hasta" aria-label="Search" aria-describedby="search-addon"  value="{{isset($filtro_fecha_vto)?$filtro_fecha_vto:''}}"/>
                                </div>
                                <div class="col-xs-3">
                                    <button type="submit" class="btn btn-outline-primary">Buscar</button>
                                </div>
                                <div class="col-lg-2">

                                </div>
                            </div>
                        </div>
                    </form>

    <br/>
    <br/>
    <div class="table-responsive">
        <table class="table table-light table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Producto</th>
                    <th>Peso</th>
                    <th>Cantidad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($ventasPorProductos as $item)
                <tr>
                    <td> {{ $item->mercaderia_id }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>$ {{ $item->peso }}</td>
                    <td>$ {{ $item->cantidad }}</td>
                    <td>
                        
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $ventasPorProductos->links("pagination::bootstrap-4") }}
    </div>

@stop
