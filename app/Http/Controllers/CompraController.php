<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compras = DB::table('lvl_compras as c')
                ->join('lvl_proveedores as cl','cl.id','c.proveedor_id')                      
                ->select('c.id as id',
                            DB::raw('cl.nombre_fantasia as proveedor'),
                            'c.total',
                            'c.pago', 
                            DB::raw('DATE_FORMAT(c.fecha,"%d-%m-%Y") as fecha')  
                )->paginate(15);
                
        return view('compra.index',compact("compras"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //DB::enableQueryLog();
        Compra::create([
            'id' => null,
            'proveedor_id' => 0,
            'fecha' => date('Y-m-d'),
            'total' => 0,
            'pago' => 0,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        
        //$quries = DB::getQueryLog();
        //var_dump($quries);

        $compra = Compra::findOrFail(DB::getPdo()->lastInsertId());
        return to_route('compraDetalle.edit', array('compraDetalle' => $compra->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //store
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
        $compra = Compra::findOrFail($id);
        return to_route('compraDetalle.edit', array('compraDetalle' => $compra->id));
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
    public function destroy($id)
    {
        Compra::destroy($id);

        $compras = DB::table('lvl_compras as c')
                ->join('lvl_proveedores as cl','cl.id','c.proveedor_id')                       
                ->select('c.id as id',
                            DB::raw('cl.nombre_fantasia as proveedor'),
                            'c.total',
                            'c.pago', 
                            DB::raw('DATE_FORMAT(c.fecha,"%Y-%m-%d") as fecha')  
                )->paginate(15);
                
        return view('compra.index',compact("compras"));
    }
}
