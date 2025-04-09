<?php

namespace App\Http\Controllers;

use App\Models\Mercaderia;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock = DB::table('lvl_stock as s')
                ->join('lvl_mercaderias as m','m.id','s.mercaderia_id')
                ->select('s.id as id','s.codigo','s.cantidad','s.cantidad_maxima','s.cantidad_minima',
                            DB::raw('DATE_FORMAT(s.fecha_ingreso,"%Y-%m-%d") as fecha_ingreso'),
                            'm.descripcion', 
                            DB::raw(' (CASE WHEN s.estado = 0 THEN "BLOQUEADA"
                            WHEN s.estado = 1 THEN "ACTIVA" END) as estado ')  
                )->paginate(15);     

        return view('stock.index',compact("stock"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("stock.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos = ($request->except('_token'));
        //var_dump($request);die;
        $stock = Stock::create([
                    'id' => null,
                    'mercaderia_id' => $request->mercaderia_id,
                    'codigo' => $request->codigo,
                    'cantidad' => $request->cantidad,
                    'cantidad_minima' => $request->cantidad_minima,
                    'cantidad_maxima' => $request->cantidad_maxima,
                    'estado' =>  $request->estado,
                    'fecha_ingreso' => $request->fecha_ingreso,
                    'created_at' => now(),
                    'updated_at' => null,
        ]);

        $stock = DB::table('lvl_stock as s')
                ->join('lvl_mercaderias as m','m.id','s.mercaderia_id')
                ->select('s.id as id','s.codigo','s.cantidad','s.cantidad_maxima','s.cantidad_minima',
                            DB::raw('DATE_FORMAT(s.fecha_ingreso,"%Y-%m-%d") as fecha_ingreso'),
                            'm.descripcion', 
                            DB::raw(' (CASE WHEN s.estado = 0 THEN "BLOQUEADA"
                            WHEN s.estado = 1 THEN "ACTIVA" END) as estado ')  
                )->paginate(15);     

        return view('stock.index')->with('stock',$stock);
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
        $stock = DB::table('lvl_stock as s')
                ->join('lvl_mercaderias as m','m.id','s.mercaderia_id')
                ->select('s.id as id','s.codigo','s.cantidad','s.cantidad_maxima','s.cantidad_minima',
                            DB::raw('DATE_FORMAT(s.fecha_ingreso,"%Y-%m-%d") as fecha_ingreso'),
                            'm.descripcion', 
                            DB::raw(' (CASE WHEN s.estado = 0 THEN "BLOQUEADA"
                            WHEN s.estado = 1 THEN "ACTIVA" END) as estado '),
                            'm.id as mercaderia_id'  )
        ->where('s.id',$id)
        ->first();   

        return view("stock.edit")->with('stock', $stock);
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
                
        $datos = [
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

        return view('stock.index',compact("stock"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Stock::destroy($id);

        $stock = DB::table('lvl_stock as s')
                    ->select('*')
                    ->paginate(15);     

        return redirect()->route('stock.index')->with('stock', $stock);
    }

}
