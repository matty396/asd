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
            <div class="card card-primary" style="margin-top: 20px;">
              <div class="card-header">
                <h3 class="card-title">Caja</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form class=""  action="{{route('cajaDetalle.index')}}" method="GET" id="indexgasto" enctype="multipart/form-data">
                <input type="hidden" id="metodo" name="metodo" value="">
                <input type="hidden" id="caja_id" name="caja_id" value="{{isset($caja_id)?$caja_id:''}}">
                  <div class="row">
                        <div class="col-sm-2">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="fecha_desde" class="form-label">Fecha Desde</label>
                            <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" value="{{isset($fecha_desde)?$fecha_desde:date('Y-m-d')}}">
                        </div>
                        </div>
                        <div class="col-sm-2">
                        <div class="form-group">
                            <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" value="{{isset($fecha_hasta)?$fecha_hasta:date('Y-m-d')}}">
                        </div>
                        </div>
                        <div class="col-sm-2">
                        <div class="form-group">
                            <label for="importe_inicial" class="form-label">Importe inicial</label>
                            <input type="text" class="form-control" id="importe_inicial" name="importe_inicial" value="{{isset($importe_inicial)?$importe_inicial:''}}">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="card-footer">
                        <input type="button" class="btn btn-primary hacer_caja" tabindex="5" value="Hacer Caja"></a>
                        <input type="button" class="btn btn-primary guardar" tabindex="5" value="Guardar Caja"></a>
                            <a href="{{ url('/caja') }}" class="btn btn-secondary" tabindex="5">Volver</a>
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

    VENTAS
    <div class="table-responsive">
        <table class="table table-light table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Operacion</th>
                    <th>Concepto</th>
                    <th>Codigo</th>
                    <th>Monto</th>
                    <th>Cantidad</th>
                    <th>Sub-Total</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <div style="display:none">{{$subtotal_ventas = 0}}</div>
            @foreach($ventas as $item)
                <div style="display:none">{{$subtotal_ventas += $item->monto * $item->cantidad;}}</div>
                <div style="display:none">{{$subtotal = $item->monto * $item->cantidad;}}</div>
                <tr>
                    <td>{{ $item->venta_detalle_id }}</td>
                    <td>INGRESO</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->codigo }}</td>
                    <td>{{ number_format(floatVal($item->monto),2,',','.') }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ number_format($subtotal,2,',','.')}}</td>
                    <td>{{ $item->fecha}}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $ventas->links("pagination::bootstrap-4") }}
    </div>

    COMPRAS
    <div class="table-responsive">
        <table class="table table-light table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Operacion</th>
                    <th>Concepto</th>
                    <th>Codigo</th>
                    <th>Monto</th>
                    <th>Cantidad</th>
                    <th>Sub-Total</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <div style="display:none">{{$subtotal_compras = 0}}</div>                
            @foreach($compras as $item)
            <div style="display:none">{{$subtotal_compras += $item->monto * $item->cantidad;}}</div>
            <div style="display:none">{{$subtotal = $item->monto * $item->cantidad;}}</div>
                <tr>
                    <td>{{ $item->compra_detalle_id }}</td>
                    <td>EGRESO</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->codigo }}</td>
                    <td>{{ number_format($item->monto,2,',','.') }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ number_format($subtotal,2,',','.')}}</td>
                    <td>{{ $item->fecha}}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $compras->links("pagination::bootstrap-4") }}
    </div>

    GASTOS
    <div class="table-responsive">
        <table class="table table-light table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Operacion</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Comentarios</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <div style="display:none">{{$subtotal_gastos = 0}}</div>
            @foreach($gastos as $item)
            <div style="display:none">{{$subtotal_gastos += $item->monto;}}</div>
                <tr>
                    <td>{{ $item->gasto_id }}</td>
                    <td>EGRESO</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ number_format($item->monto,2,',','.' )}}</td>
                    <td>{{ $item->comentarios }}</td>
                    <td>{{ $item->fecha}}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $compras->links("pagination::bootstrap-4") }}

        RESUMEN
        <div class="table-responsive">
        <table class="table table-light table-hover">
            <thead class="thead-light">
                <tr>
                    <th>INGRESOS</th>
                    <th>EGRESOS</th>
                    <th>RESULTADO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($gastos as $item)
            <div style="display:none">{{$subtotal_gastos += $item->monto;}}</div>
            <div style="display:none">{{$subtotal_egresos = $subtotal_compras + $subtotal_gastos}}</div>
            <div style="display:none">{{$total = $subtotal_compras - ($subtotal_compras + $subtotal_gastos)}}</div>
                <tr>
                    <td style="color:green">{{ number_format($subtotal_ventas,2,',','.') }}</td>
                    <td style="color: red;">{{ number_format($subtotal_egresos,2,',','.')}}</td>
                    <td style="color:blue">{{  number_format($total,2,',','.')}}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @stop
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="{{asset('vendor/Jquery-ui/jquery-ui.min.css')}}">
<script src="{{asset('vendor/Jquery-ui/jquery-ui.min.js')}}"></script>
<script type='text/javascript'>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

        $(".hacer_caja").click(function (e) {
                $("#metodo").val("FILTRO");
                $("#indexgasto").submit();
            });

        $(".guardar").click(function (e) {//alert($('meta[name="csrf-token"]').attr('content'));
                $("#metodo").val("GUARDAR");
                $("#indexgasto").submit();
            });
    });
</script>

