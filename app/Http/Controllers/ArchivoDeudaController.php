<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchivoDeuda;
use App\Models\ArchivoDeudaDetalle;
use App\Models\archivoDeudaDetalle as ModelsArchivoDeudaDetalle;
use Illuminate\Support\Facades\DB;
class ArchivoDeudaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $archivosDeudas = ArchivoDeuda::select('*')->paginate(3);
        $archivoDeudaDetalle = new ArchivoDeudaDetalle();
        return view('archivoDeuda.index')->with("archivosDeudas",$archivosDeudas)
                                            ->with("archivoDeudaDetalle",$archivoDeudaDetalle);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("archivoDeuda.index");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosArchivoDeuda = array(
            "nombre"=>"XXXX-YY-DD",
            "estado"=>"1",
            "created"=>now(),
            "updated"=> now(),
        );
        ArchivoDeuda::insert($datosArchivoDeuda);
        $id = DB::getPdo()->lastInsertId();
        $archivoDeudaDetalle = new ArchivoDeudaDetalle();
        $archivosDeudas = ArchivoDeuda::select('*')->paginate(10);
        return view("archivoDeuda.index")->with("archivosDeudas",$archivosDeudas)
                                        ->with("archivo_deuda_id",$id)
                                        ->with("archivoDeudaDetalle",$archivoDeudaDetalle);
    }
    
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   echo "ENTRA A SHOW";die;
       
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function exportar($id)
    {
        echo "entra a la exportacion ";die;
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
        //
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
