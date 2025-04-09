<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\CajaDetalle;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Gasto;
use App\Models\Mercaderia;
use App\Models\Stock;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\Rule\Parameters;
use Ramsey\Uuid\Type\Integer;
use Symfony\Component\Console\Input\Input;

class CajaDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ventas = VentaDetalle::where('id',-1)->paginate(20);
        $compras = CompraDetalle::where('id',-1)->paginate(20);
        $gastos = Gasto::where('id',-1)->paginate(20);
        $caja_id = isset($_GET['cajaDetalle'])?$_GET['cajaDetalle']:'';
        if ($request->metodo == "GUARDAR"){
            /**Insertar detalle venta en cajadetalle */
            $caja_id = $_GET['caja_id'];
            $importe_inicial = $_GET['importe_inicial'];
            $fecha_desde = $_GET['fecha_desde'];
            $fecha_hasta = $_GET['fecha_hasta'];
            $total_ventas = 0;
            $total_compras = 0;
            $total_gastos = 0;
            $ventas = DB::table('lvl_ventas as v')
                    ->join('lvl_ventas_detalle as vd','vd.venta_id','v.id')
                    ->join('lvl_clientes as c','c.id', 'v.cliente_id')
                    ->whereRaw("v.fecha >= CONCAT('$request->fecha_desde',' 00:00:00')")
                    ->whereRaw("v.fecha <= CONCAT('$request->fecha_hasta',' 00:00:00')")
                    ->select('vd.id as venta_detalle_id', 'vd.descripcion', 'vd.codigo', 'vd.monto', 'vd.cantidad' ,
                                DB::raw('DATE_FORMAT(v.fecha,"%d-%m-%Y") as fecha', 'c.apellidos'))

                    ->get();
            
                    $ventas_data[] = null ;
                    foreach($ventas as $value) {
                        $ventas_data = array( 'id' => null,
                                            'caja_id' => $caja_id, 
                                            'tipooperacion_id' => 1 , 
                                            'concepto' => $value->descripcion,
                                            'codigo'=>$value->codigo,
                                            'monto'=>$value->monto,
                                            'cantidad'=>$value->cantidad,
                                            'created_at'=> now(),
                                            'updated_at'=>  now()
                                            );
                        $total_ventas += $total_ventas+($value->monto * $value->cantidad); 
                    }
                    //DB::enableQueryLog();
                    //dd($ventas_data);die;
                    DB::table('lvl_caja_detalle')->insert($ventas_data);
                    //$quries = DB::getQueryLog();
                    //var_dump($quries);die;
            /**Fin insertar */
            /**Insertar detalle compra en cajadetalle */
            $compras = DB::table('lvl_compras as c')
                    ->join('lvl_compras_detalle as cd','cd.compra_id','c.id')
                    ->join('lvl_proveedores as p','p.id', 'c.proveedor_id')
                    ->whereRaw("c.fecha >= CONCAT('$request->fecha_desde',' 00:00:00')")
                    ->whereRaw("c.fecha <= CONCAT('$request->fecha_hasta',' 00:00:00')")
                    ->select('cd.id as compra_detalle_id', 'cd.descripcion', 'cd.codigo', 'cd.monto', 'cd.cantidad', 
                                DB::raw('DATE_FORMAT(c.fecha,"%d-%m-%Y") as fecha'),
                                'p.nombre_fantasia')

                    ->get();
                    $compras_data[] = null;
                    foreach($compras as $value) {
                        $compras_data = array( 'id' => null,
                                            'caja_id' => $caja_id, 
                                            'tipooperacion_id' => 0 , 
                                            'concepto' => $value->descripcion,
                                            'codigo'=>$value->codigo,
                                            'monto'=>$value->monto,
                                            'cantidad'=>$value->cantidad,
                                            'created_at'=>date("Y-m-d"),
                                            'updated_at'=>date("Y-m-d")
                                        ); 
                        $total_compras += $total_compras + ($value->monto * $value->cantidad);
                    }
                    
                    DB::table('lvl_caja_detalle')->insert($compras_data);
            /**fin insertar */
            /**insertar detalle gastos en cajadetalle */
            $gastos = DB::table('lvl_gastos as g')
                        ->whereRaw("g.fecha >= CONCAT('$request->fecha_desde',' 00:00:00')")
                        ->whereRaw("g.fecha <= CONCAT('$request->fecha_hasta',' 00:00:00')")
                        ->select('g.id as gasto_id', 'g.descripcion', 'g.monto', 'g.comentarios',
                                DB::raw('DATE_FORMAT(g.fecha,"%d-%m-%Y") as fecha'))

                    ->get();
                    $gastos_data[] = null;
                    foreach($gastos as $value) {
                        $gastos_data = array( 'id' => null,
                                            'caja_id' => $caja_id, 
                                            'tipooperacion_id' => 0 , 
                                            'concepto' => $value->descripcion,
                                            'codigo'=> '0',
                                            'monto'=> $value->monto,
                                            'cantidad'=> 1,
                                            'created_at'=> date("Y-m-d"),
                                            'updated_at'=>date("Y-m-d")
                                        ); 
                        $total_gastos += $total_gastos + $value->monto;
                    }
                    
                    DB::table('lvl_caja_detalle')->insert($gastos_data);
                    
                    $caja_data = [
                        'inicial' => $importe_inicial, 
                        'ventas' =>$total_ventas,
                        'compras' =>$total_compras,
                        'gastos' =>$total_gastos,
                        'fecha_desde'=>$fecha_desde,
                        'fecha_hasta'=>$fecha_hasta,
                        'total' => $importe_inicial + $total_ventas - $total_compras - $total_gastos
                    ];

                    $caja = Caja::findOrFail($caja_id);
                    $caja->update($caja_data);

                    return to_route('caja.index',array('fecha_desde'=>$fecha_desde,'fecha_hasta'=>$fecha_hasta,'importe_inicial'=>$importe_inicial));
            /**fin insertar */
            
        }
        if($request->metodo == "FILTRO"){
            $caja_id = $_GET['caja_id'];
            $importe_inicial = $_GET['importe_inicial'];
            $fecha_desde = $_GET['fecha_desde'];
            $fecha_hasta = $_GET['fecha_hasta'];
            $total_ventas = 0;
            $total_compras = 0;
            $total_gastos = 0; 
            //DB::enableQueryLog();
            $ventas = DB::table('lvl_ventas as v')
                    ->join('lvl_ventas_detalle as vd','vd.venta_id','v.id')
                    ->join('lvl_clientes as c','c.id', 'v.cliente_id')
                    ->whereRaw("v.fecha >= CONCAT('$request->fecha_desde',' 00:00:00')")
                    ->whereRaw("v.fecha <= CONCAT('$request->fecha_hasta',' 00:00:00')")
                    ->select('vd.id as venta_detalle_id', 'vd.descripcion', 'vd.codigo', 'vd.monto', 'vd.cantidad' ,
                                DB::raw('DATE_FORMAT(v.fecha,"%d-%m-%Y") as fecha', 'c.apellidos'))

                    ->paginate(20); 
                
            //$quries = DB::getQueryLog();
            //var_dump($quries);die;  
            $compras = DB::table('lvl_compras as c')
                    ->join('lvl_compras_detalle as cd','cd.compra_id','c.id')
                    ->join('lvl_proveedores as p','p.id', 'c.proveedor_id')
                    ->whereRaw("c.fecha >= CONCAT('$request->fecha_desde',' 00:00:00')")
                    ->whereRaw("c.fecha <= CONCAT('$request->fecha_hasta',' 00:00:00')")
                    ->select('cd.id as compra_detalle_id', 'cd.descripcion', 'cd.codigo', 'cd.monto', 'cd.cantidad', 
                                DB::raw('DATE_FORMAT(c.fecha,"%d-%m-%Y") as fecha'),
                                'p.nombre_fantasia')

                    ->paginate(20);
            
            $gastos = DB::table('lvl_gastos as g')
                        ->whereRaw("g.fecha >= CONCAT('$request->fecha_desde',' 00:00:00')")
                        ->whereRaw("g.fecha <= CONCAT('$request->fecha_hasta',' 00:00:00')")
                        ->select('g.id as gasto_id', 'g.descripcion', 'g.monto', 'g.comentarios',
                                DB::raw('DATE_FORMAT(g.fecha,"%d-%m-%Y") as fecha'))

                    ->paginate(20);
                    return view('cajaDetalle.index',compact('ventas','compras','gastos','caja_id','fecha_desde','fecha_hasta','importe_inicial'));
        }

        $cajaDetalle = CajaDetalle::where('caja_id',$caja_id)->paginate(20);
        return view('cajaDetalle.index',compact('cajaDetalle','ventas','compras','gastos','caja_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/**Lo que se cambie aqui cambiar en el EDIT*/
        echo "caja detalle store";die;
        $caja_id = $request->caja_id;
        $mercaderia = Mercaderia::where('codigo',$request->codigo)->first();
        /**Creo un item para el detalle de la venta */
        $cajaDetalle = CajaDetalle::create([
            'id' => null,
            'caja_id'=> $caja_id,
            'mercaderia_id' => $mercaderia->id,
            'descripcion'=> $request->descripcion,
            'codigo'=> $request->codigo,
            'monto'=>$request->precio_unitario,
            'cantidad' => $request->cantidad,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        /**Disminuyo del stock la mercaderia */
        $stock = Stock::where('mercaderia_id',$mercaderia->id)->first();
        $stock_data = ['cantidad' => (int)$stock->cantidad - (int)$request->cantidad];
        $stock->update($stock_data);
        /**Si el metodo es GuardarYSalir entonces no vuelvo a la misma pagiana
         * Grabo el total de todas las ventas que van en el campo de la CAJA
         * Y ademas se vuelve a index de Cajas
         */
        if($request->metodo == "guardarSalir"){
            $cajaDetalles = CajaDetalle::where('caja_id',$caja_id)->get();
            $cajaTotal = 0;
            foreach($cajaDetalles as $value){
                $cajaTotal += (double)$value->monto * (int)$value->cantidad;
            }
    
            $caja = Caja::findOrFail($caja_id);
            $caja_data = ['cliente_id'=> $request->cliente_id,
                            'total'=>$cajaTotal];
            $caja->update($caja_data);
        }
        
        /**Si el metodo es GuardarCopiar se regresa al detalle para
         * seguir cargando items
         */
        $cajaDetalle = CajaDetalle::where('caja_id',$caja_id)->paginate(15);
        return [ 'respuesta' => $cajaDetalle,'caja_id'=>$caja_id];
                                                
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($caja_id)
    {
        $caja = Caja::findOrFail($caja_id);
        $cajaDetalle = CajaDetalle::where('caja_id',$caja_id)->paginate(15);
        return view("caja.edit")->with('cajaDetalle',$cajaDetalle)->with('caja',$caja)->with('comprobante_id',$caja->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo "entra al update cajaController";die;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
