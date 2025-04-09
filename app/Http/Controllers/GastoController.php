<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GastoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gastos = DB::table('lvl_gastos as g')
                ->select('g.id',
                            'g.descripcion',
                            'g.monto',
                            'g.comentarios', 
                            DB::raw('DATE_FORMAT(g.fecha,"%d-%m-%Y") as fecha')  
                )->paginate(15);
                
        return view('gasto.index',compact("gastos"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gasto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gasto::create([
            'id' => null,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'comentarios' => $request->comentarios,
            'fecha' => date('Y-m-d'),
            'created_at' => now(),
            'updated_at' => null,
        ]);
        
        return view('gasto.index');
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
        $gasto = DB::table('lvl_gastos as g')
                ->where('g.id',$id)
                ->select('g.id',
                            'g.descripcion',
                            'g.monto',
                            'g.comentarios', 
                            DB::raw('DATE_FORMAT(g.fecha,"%Y-%m-%d") as fecha')  
                            
                )->first();
                
        return view('gasto.edit',compact("gasto"));
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
        $gasto_data = [
            'descripcion'=>$request->descripcion,
            'monto'=>$request->monto,
            'comentarios'=>$request->comentarios,
            'fecha'=>now()
        ];

        $gasto = Gasto::findOrFail($id);
        $gasto->update($gasto_data);

        $gastos = DB::table('lvl_gastos as g')
                ->select('g.id',
                            'g.descripcion',
                            'g.monto',
                            'g.comentarios', 
                            DB::raw('DATE_FORMAT(g.fecha,"%d-%m-%Y") as fecha')  
                )->paginate(15);
                
        return view('gasto.index',compact("gastos"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gasto::destroy($id);

        $gastos = DB::table('lvl_gastos as g')
                ->select('g.id',
                            'g.descripcion',
                            'g.monto',
                            'g.comentarios', 
                            DB::raw('DATE_FORMAT(g.fecha,"%d-%m-%Y") as fecha')  
                )->paginate(15);
                
        return view('gasto.index',compact("gastos"));
    }
}
