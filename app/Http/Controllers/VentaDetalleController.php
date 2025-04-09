<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Mercaderia;
use App\Models\Stock;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**Lo que se cambie aqui cambiar en el EDIT*/
        $venta_id = $request->venta_id;
        $mercaderia = Mercaderia::where('codigo',$request->codigo)->first();
        /**Creo un item para el detalle de la venta */
        if($request->metodo == "guardarCopiar"){
            $ventaDetalle = VentaDetalle::create([
                'id' => null,
                'venta_id'=> $venta_id,
                'mercaderia_id' => $mercaderia->id,
                'descripcion'=> $request->descripcion,
                'codigo'=> $request->codigo,
                'monto'=>$request->precio_unitario,
                'cantidad' => $request->cantidad,
                'created_at' => now(),
                'updated_at' => null,
            ]);
            //$quries = DB::getQueryLog();
            //var_dump($quries);
            /**Disminuyo del stock la mercaderia */
            $stock = Stock::where('mercaderia_id',$mercaderia->id)->first();
            $stock_data = ['cantidad' => (int)$stock->cantidad - (int)$request->cantidad];
            $stock->update($stock_data);
        }
        
        /**Si el metodo es GuardarYSalir entonces no vuelvo a la misma pagiana
         * Grabo el total de todas las ventas que van en el campo de la VENTA
         * Y ademas se vuelve a index de ventas
         */
        $venta = Venta::findOrFail($venta_id);
        if ($venta->cliente_id == 0){
            $venta_data = ['cliente_id'=> $request->cliente_id];
            $venta->update($venta_data);
        }

        if($request->metodo == "guardarSalir"){
            $ventaDetalles = VentaDetalle::where('venta_id',$venta_id)->get();
            $ventaTotal = 0;
            foreach($ventaDetalles as $value){
                $ventaTotal += (double)$value->monto * (int)$value->cantidad;
            }

            $venta = Venta::findOrFail($venta_id);
            $venta_data = ['total'=>$ventaTotal,
                            'pago' =>$request->pago];
            $venta->update($venta_data);
            
        }
        /**Si el metodo es GuardarCopiar se regresa al detalle para
         * seguir cargando items
         */
        ///DB::enableQueryLog();
        $ventaDetalle = VentaDetalle::where('venta_id',$venta_id)->paginate(15);
        //$quries = DB::getQueryLog();
        //var_dump($quries);
        return [ 'respuesta' => $ventaDetalle,'venta_id'=>$venta_id];
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
    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        $ventaDetalle = VentaDetalle::where('venta_id',$id)->paginate(15);

        $cliente = DB::table('lvl_clientes as c')
                    ->join('lvl_personas as p','p.id','c.persona_id')
        ->select('*')
        ->where('c.id',$venta->cliente_id)->first();

        return view('venta.edit')->with('ventaDetalle', $ventaDetalle)
                                        ->with('venta', $venta)
                                        ->with('comprobante_id', $id)
                                        ->with('cliente',$cliente);
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
        //update
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        
        VentaDetalle::destroy($request->id);
        return [ 'venta_id'=>$request->venta_id];
       /* $ventas = DB::table('lvl_ventas as c')
                ->join('lvl_clientes as cl','cl.id','c.cliente_id')
                ->join('lvl_personas as p','p.id','cl.persona_id')                        
                ->select('c.id as id',
                            DB::raw('CONCAT(p.apellidos,", ",p.nombres) as cliente'),
                            'c.total',
                            'c.pago', 
                            DB::raw('DATE_FORMAT(c.fecha,"%Y-%m-%d") as fecha')  
                )->paginate(15);
                
        return view('venta.index',compact("ventas"));*/
    }

    public function reportesVentas(){
        $ventasPorProductos = VentaDetalle::whereId('0')->paginate(20);
        return view('reportes/ventasPorProductos')->with("ventasPorProductos",$ventasPorProductos);
    }

    public function ventasPorProductos(Request $request)
    {
        //dd($request->all());die;
        $fecha_desde = $request!=null?$request->input('fecha_desde'):null;
        $fecha_hasta = $request!=null?$request->input('fecha_hasta'):null;
        //DB::enableQueryLog();
        $query = DB::table('lvl_ventas_detalle as vd')
                ->join('lvl_ventas as v','v.id','=', 'vd.venta_id')
                ->join('lvl_mercaderias as m','vd.mercaderia_id','=', 'm.id')
            
                ->select('m.id as mercaderia_id', 'm.descripcion as descripcion',
                    'm.peso as peso',
                    DB::raw('sum(vd.cantidad) as cantidad'))
                    ->groupBy('m.id','m.descripcion','m.peso')
                //->where('v.fecha >= 2023-01-01')
                //->where('v.fecha <= 2023-11-01')    
                ->orderBy('cantidad','desc')     ; 
            
                if($fecha_desde!='') {
                    $query->where('v.fecha','>=',$fecha_desde);
                }
                
                if($fecha_hasta!='') {
                    $query->where('v.fecha','>=',$fecha_hasta);
                }
        $query =  $query->paginate(20);
        //$quries = DB::getQueryLog();
        //var_dump($quries);die;
        //echo $query;die;
        //$archivodeuda_id = $archivo_deuda_id;
        return view('reportes.ventasPorProductos')->with("ventasPorProductos",$query)
                                ->with("fecha_desde",$fecha_desde)
                                ->with("fecha_hasta",$fecha_hasta);

       /* $ventas = DB::table('lvl_ventas as c')
                ->join('lvl_clientes as cl','cl.id','c.cliente_id')
                ->join('lvl_personas as p','p.id','cl.persona_id')                        
                ->select('c.id as id',
                            DB::raw('CONCAT(p.apellidos,", ",p.nombres) as cliente'),
                            'c.total',
                            'c.pago', 
                            DB::raw('DATE_FORMAT(c.fecha,"%Y-%m-%d") as fecha')  
                )->paginate(15);
                
        return view('venta.index',compact("ventas"));*/
    }

}
