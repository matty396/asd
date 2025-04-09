<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = DB::table('lvl_ventas as c')
                ->join('lvl_clientes as cl','cl.id','c.cliente_id')
                ->join('lvl_personas as p','p.id','cl.persona_id')                        
                ->select('c.id as id',
                            DB::raw('CONCAT(p.apellidos,", ",p.nombres) as cliente'),
                            'c.total',
                            'c.pago', 
                            DB::raw('DATE_FORMAT(c.fecha,"%d-%m-%Y") as fecha')  
                )->paginate(15);
                
        return view('venta.index',compact("ventas"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //DB::enableQueryLog();
        Venta::create([
            'id' => null,
            'cliente_id' => 0,
            'fecha' => date('Y-m-d'),
            'total' => 0,
            'pago' => 0,
            'created_at' => now(),
            'updated_at' => null,
        ]);
        
        //$quries = DB::getQueryLog();
        //var_dump($quries);

        $venta = Venta::findOrFail(DB::getPdo()->lastInsertId());
        return to_route('ventaDetalle.edit', array('ventaDetalle' => $venta->id));
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
        $venta = Venta::findOrFail($id);
        return to_route('ventaDetalle.edit', array('ventaDetalle' => $venta->id));
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
        Venta::destroy($id);

        $ventas = DB::table('lvl_ventas as c')
                ->join('lvl_clientes as cl','cl.id','c.cliente_id')
                ->join('lvl_personas as p','p.id','cl.persona_id')                        
                ->select('c.id as id',
                            DB::raw('CONCAT(p.apellidos,", ",p.nombres) as cliente'),
                            'c.total',
                            'c.pago', 
                            DB::raw('DATE_FORMAT(c.fecha,"%Y-%m-%d") as fecha')  
                )->paginate(15);
                
        return view('venta.index',compact("ventas"));
    }
}
