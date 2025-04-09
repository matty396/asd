<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\CajaDetalle;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caja = DB::table('lvl_caja as c')
                ->select('c.id as id',
                            'c.inicial',
                            'c.ventas',
                            'c.compras',
                            'c.gastos',
                            'c.total', 
                            DB::raw('DATE_FORMAT(c.fecha_desde,"%Y-%m-%d") as fecha_desde'),  
                            DB::raw('DATE_FORMAT(c.fecha_hasta,"%Y-%m-%d") as fecha_hasta')  
                )->paginate(15);
                
        return view('caja.index',compact("caja"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //var_dump($request);die;
        //DB::enableQueryLog();
        Caja::create([
            'id' => null,
            'ventas' => 0,
            'compras' => 0,
            'gastos' => 0,
            'fecha_desde' => date('Y-m-d 00:00:00'),
            'fecha_hasta' => date('Y-m-d 23:59:59'),
            'total' => 0,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        
        //$quries = DB::getQueryLog();
        //var_dump($quries);

        $caja = Caja::findOrFail(DB::getPdo()->lastInsertId());
        $cajaDetalle = CajaDetalle::where('caja_id',$caja->id)->paginate(15);
        return to_route('cajaDetalle.index', array('cajaDetalle' => $caja->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        var_dump($request);die;
        /*$stock = Stock::where('codigo',$request->codigo);
        $cantidad_stock = intval($stock->cantidad) - intval($request->cantidad);
        $stock_data = [
            'cantidad' => $cantidad_stock,
            'updated_at' => now(),
        ];

        $stock->update($stock_data);
        
        $stock = DB::table('lvl_stock as s')
                ->join('lvl_mercaderias as m','m.id','s.mercaderia_id')
                ->select('s.id as id','s.codigo','s.cantidad','s.cantidad_maxima','s.cantidad_minima',
                            DB::raw('DATE_FORMAT(s.fecha_ingreso,"%Y-%m-%d") as fecha_ingreso'),
                            'm.descripcion', 
                            DB::raw(' (CASE WHEN s.estado = 0 THEN "BLOQUEADA"
                            WHEN s.estado = 1 THEN "ACTIVA" END) as estado ')  
                )->paginate(15);     

        return view('stock.index')->with('stock',$stock);*/
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
        /*$stock = DB::table('lvl_stock as s')
                ->join('lvl_mercaderias as m','m.id','s.mercaderia_id')
                ->select('s.id as id','s.codigo','s.cantidad','s.cantidad_maxima','s.cantidad_minima',
                            DB::raw('DATE_FORMAT(s.fecha_ingreso,"%Y-%m-%d") as fecha_ingreso'),
                            'm.descripcion', 
                            DB::raw(' (CASE WHEN s.estado = 0 THEN "BLOQUEADA"
                            WHEN s.estado = 1 THEN "ACTIVA" END) as estado '),
                            'm.id as mercaderia_id'  )
        ->where('s.id',$id)
        ->first();   

        return view("stock.edit")->with('stock', $stock);*/
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
        /*$datos = [
            'mercaderia_id' => $request->mercaderia_id,
            'codigo' => $request->codigo,
            'cantidad' => $request->cantidad,
            'cantidad_minima' => $request->cantidad_minima,
            'cantidad_maxima' => $request->cantidad_maxima,
            'estado' =>  $request->estado,
            'fecha_ingreso' => $request->fecha_ingreso,
            'created_at' => now(),
            'updated_at' => null,
        ];
       
        $stock = Stock::findOrFail($id);
        $stock->update($datos);

        $stock = DB::table('lvl_stock as s')
                ->join('lvl_mercaderias as m','m.id','s.mercaderia_id')
                ->select('s.id as id','s.codigo','s.cantidad','s.cantidad_maxima','s.cantidad_minima',
                            DB::raw('DATE_FORMAT(s.fecha_ingreso,"%Y-%m-%d") as fecha_ingreso'),
                            'm.descripcion', 
                            DB::raw(' (CASE WHEN s.estado = 0 THEN "BLOQUEADA"
                            WHEN s.estado = 1 THEN "ACTIVA" END) as estado ')  
                )->paginate(15);     

        return view('stock.index',compact("stock"));*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = DB::table('lvl_caja_detalle')->where('caja_id', $id)->delete();
        Caja::destroy($id);

        $caja = DB::table('lvl_caja as s')
                    ->select('*')
                    ->paginate(15);     

        return redirect()->route('caja.index')->with('cajas', $caja);
    }
}
