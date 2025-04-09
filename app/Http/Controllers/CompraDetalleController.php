<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Mercaderia;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $compra_id = $request->compra_id;
        $mercaderia = Mercaderia::where('codigo',$request->codigo)->first();
        /**Creo un item para el detalle de la venta */
        if($request->metodo == "guardarCopiar"){
            $compraDetalle = CompraDetalle::create([
                'id' => null,
                'compra_id'=> $compra_id,
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
            if ($stock == null){
                $stock = Stock::create([
                    'id' => null,
                    'mercaderia_id' => $mercaderia->id,
                    'codigo'=> $request->codigo,
                    'cantidad' => $request->cantidad,
                    'estado'=> 1,
                    'fecha_ingreso' => now(),
                    'created_at' => now(),
                    'updated_at' => null,
                ]);
            }
            $stock_data = ['cantidad' => (int)$stock->cantidad + (int)$request->cantidad];
            $stock->update($stock_data);
        }
        
        /**Si el metodo es GuardarYSalir entonces no vuelvo a la misma pagiana
         * Grabo el total de todas las ventas que van en el campo de la VENTA
         * Y ademas se vuelve a index de ventas
         */
        $compra = Compra::findOrFail($compra_id);
        if ($compra->proveedor_id == 0){
            $compra_data = ['proveedor_id'=> $request->proveedor_id];
            $compra->update($compra_data);
        }

        if($request->metodo == "guardarSalir"){
            $compraDetalles = CompraDetalle::where('compra_id',$compra_id)->get();
            $compraTotal = 0;
            foreach($compraDetalles as $value){
                $compraTotal += (double)$value->monto * (int)$value->cantidad;
            }

            $compra = Compra::findOrFail($compra_id);
            $compra_data = ['total'=>$compraTotal,
                            'pago' =>$request->pago];
            $compra->update($compra_data);
        }
        
        /**Si el metodo es GuardarCopiar se regresa al detalle para
         * seguir cargando items
         */
        $compraDetalle = CompraDetalle::where('compra_id',$compra_id)->paginate(15);
        return [ 'respuesta' => $compraDetalle,'compra_id'=>$compra_id];
                                                
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
    public function edit($compra_id)
    {
        $compra = Compra::findOrFail($compra_id);
        $proveedor = DB::table('lvl_proveedores as c')
        ->select('*')
        ->where('c.id',$compra->proveedor_id)->first();
        
        $compraDetalle = CompraDetalle::where('compra_id',$compra_id)->paginate(15);
        return view("compra.edit")->with('compraDetalle',$compraDetalle)
                                    ->with('compra',$compra)
                                    ->with('comprobante_id',$compra->id)
                                    ->with('proveedor',$proveedor);
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
        echo "entra al update compraController";die;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $compraDetalle = CompraDetalle::findOrFail($id);
        $compra = Compra::findOrFail($compraDetalle->compra_id);
        CompraDetalle::destroy($id);

        $proveedor = DB::table('lvl_proveedores as c')
        ->select('*')
        ->where('c.id',$compra->proveedor_id)->first();

        $compraDetalle = CompraDetalle::where('compra_id',$compra->id)->paginate(15);
        
        return view("compra.edit")->with('compraDetalle',$compraDetalle)
                                    ->with('compra',$compra)
                                    ->with('comprobante_id',$compra->id)
                                    ->with('proveedor',$proveedor);
    }
}
