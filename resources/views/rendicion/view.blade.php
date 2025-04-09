@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h4>Detalle de la rendicion {{$rendicionesDetalle[0]->header_id}}</h4>
@stop

@section('content')
    <div class="container">
    @if(Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
        {{  Session::get('mensaje')}}
        </div>
    @endif
    
   
    <form method="GET" action="{{ url('/rendicion') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
        <span style="margin-right: 1.2em;">
       
        </span>
    </form>

    <br/>
    <div class="table-responsive">
        <table class="table table-light table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Clave</th>
                    <th>Descripcion</th>
                    <th>Nro Trx</th>
                    <th>Fecha/Hora</th>
                    <th>Nro Lote</th>
                    <th>Importe</th>
                    <th>Moneda</th>
                    <th>Modo Pago</th>
                </tr>
            </thead>
            <tbody>
            @foreach($rendicionesDetalle as $item)
                <?php $forma_pago = "";if($item->forma_pago==90){$forma_pago = "TARJETA";
                                        }else{if($item->forma_pago==80){$forma_pago = "CREDITO";
                                        }else{if($item->forma_pago==60){$forma_pago = "TARJETA";}}}?>
                        
                <tr>
                    <td>{{ preg_replace('/^0+/', '', $item->clave_1)." - ".preg_replace('/^0+/', '', $item->clave_2)." - ".preg_replace('/^0+/', '', $item->clave_3) }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->nro_trx }}</td>
                    <td>{{ date('m/d/Y H:i:s', $item->fecha_pago."".$item->hora_transaccion) }}</td>
                    <td>{{ $item->nro_lote }}</td>
                    <td>{{ substr($item->importe,0,-2).",".substr($item->importe,-2 )}}</td>
                    <td>{{ $item->moneda==0?"PESOS":"DOLARES" }}</td>
                    <td>{{ $forma_pago }}</td>
                    <td>
                        <a href="{{url('rendicionDetalle/'.$item->id.'/edit')}}" title="Editar registro"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>

                        <form method="POST" action="{{ url('/rendicion' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Borrar registro" onclick="return Confirm('delete')"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $rendicionesDetalle->links("pagination::bootstrap-4") }}
    </div>

@stop
