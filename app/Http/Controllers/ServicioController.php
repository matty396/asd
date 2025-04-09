<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicio::select('*')->paginate(10);
        return view('servicio.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('servicio.create');
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
        
        Servicio::create([
                    'id' => null,
                    'nombre' => $request->nombre,
                    'monto' => $request->monto,
                    'observaciones' => $request->observaciones,
                    'created_at' => now(),
                    'updated_at' => null,
        ]);
        $servicios = Servicio::select("*")->paginate();
        return view('servicio.index',compact("servicios"));
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
        $servicio = Servicio::findOrFail($id);
        return view('servicio.edit',compact("servicio"));
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
            'nombre' => $request->nombre,
            'monto' => $request->monto,
            'observaciones' => $request->observaciones,
            'created_at' => now(),
            'updated_at' => null,
        ];
       
        $servicio = Servicio::findOrFail($id);
        $servicio->update($datos);
        
        $servicios = Servicio::select("*")->paginate();
        return view('servicio.index',compact("servicios"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Servicio::destroy($id);
        $servicios = Servicio::select("*")->paginate();
        return view('servicio.index',compact("servicios"));
    }

    public function getServicioPorCod(Request $request)
    {     
        $parsubcod = $request->input('parsubcod');

        $servicio = Servicio::find($parsubcod);
                
       return response()->json($servicio);
    }
}
