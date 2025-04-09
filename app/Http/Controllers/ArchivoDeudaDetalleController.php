<?php

namespace App\Http\Controllers;

use App\Models\ArchivoDeuda;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\archivoDeudaDetalle;
class ArchivoDeudaDetalleController extends Controller
{
    const COD_ENT = "24391758";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $archivosDeudasDetalle = ArchivoDeudaDetalle::all();
        return view('archivoDeudaDetalle.index')->with("archivosDeudasDetalle",$archivosDeudasDetalle);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "create";die;
        return view("archivoDeudaDetalle.create")->with("archivoDeudaDetalle",array());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        
        ArchivoDeudaDetalle::create([
                    'id' => null,
                    'archivo_deuda_id' => $request->archivodeuda_id,
                    'socio_nro' => $request->socio_nro,
                    'id_servicio' => $request->parsubcod,
                    'vto_1' => $request->fec_1er_vto,
                    'vto_2' => $request->fec_2do_vto,
                    'vto_3' => $request->fec_3er_vto,
                    'importe_1' => $request->imp_1er_vto,
                    'importe_2' => $request->imp_2do_vto,
                    'importe_3' => $request->imp_3er_vto,
                    'created_at' => now(),
                    'updated_at' => '',
        ]);
        $archivoDeudaDetalle = ArchivoDeudaDetalle::all();
        return view("archivoDeudaDetalle.create")->with("archivoDeudaDetalle",$archivoDeudaDetalle)
                                                ->with("archivodeuda_id",$request->archivodeuda_id);
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
    public function edit($id){
        $archivoDeudaDetalle = ArchivoDeudaDetalle::where('archivo_deuda_id',$id)->paginate(2);/*0DB::table ('lvl_archivos_deudas_detalles')
                            ->where('archivo_deuda_id  = '.$id)->get();*/
                            
        $archivodeuda_id = $id;
        return view('archivoDeudaDetalle.create')->with("archivoDeudaDetalle",$archivoDeudaDetalle)
                                                ->with("archivodeuda_id",$archivodeuda_id);
        
    }
    

    public function exportar($id){
        // Fetch records from database 
        //$archivoDeuda = ArchivoDeuda::findOrFail($id);
        $archivoDeudaDetalle = ArchivoDeudaDetalle::where('archivo_deuda_id',$id)->get();

        if(count($archivoDeudaDetalle) > 0){ 
            $delimiter = ";"; 
            $filename =  self::COD_ENT. date('Ymd') . ".pac"; 
            
            // Create a file pointer 
            $f = fopen('php://memory', 'w'); 
            
            // CABECERA
            $fields = array('1',//COD_REGISTRO(obligatorio)
                            'R',//TIPO_OPERACION(obligatorio fijo)
                            '103',//COD_ENTIDAD (opcional fijo )
                            '',//NOMBRE_ENTIDAD(opcional)
                            date("Ymd"),//(obligatorio)
                            self::COD_ENT,//COD_ENTE(obligatorio)
                            '','','','','','','','','','','','','','',''); 
            fputcsv($f, $fields, $delimiter); 
            
            // DETALLE
            $total_vto_1 = 0;
            $total_vto_2 = 0;
            $total_vto_3 = 0;
            $cant_registros_detalle = 0;
            foreach($archivoDeudaDetalle as $value){ 
                $vto1_stamp = strtotime($value->vto_1);
                $vto_1 = date("Ymd",$vto1_stamp);
                $vto2_stamp = strtotime($value->vto_2);
                $vto_2 = date("Ymd",$vto2_stamp);
                $vto3_stamp = strtotime($value->vto_3);
                $vto_3 = date("Ymd",$vto3_stamp);
                $lineData = array('6',//COD-REGISTRO (obligatorio fijo)
                            $value->id_servicio, //PARSUBCOD
                            $value->importe_1,
                            $value->importe_2,
                            $value->importe_3,'','','',
                            $vto_1,
                            $vto_2,
                            $vto_3,'','','',
                            $value->socio_nro,'','',//Clave1, clave2, clave3
                            '',//Descripcion
                            '','','',//Filler1, Filler2, Filler3
                            );
                    $total_vto_1 += $value->importe_1;
                    $cant_registros_detalle++;
                    fputcsv($f, $lineData, $delimiter); 
            } 
            
            // PIE 
            $fields = array('9',//COD_REGISTRO(obligatorio fijo)
                            '',//COD-ENTIDAD(opcional fijo)
                            $total_vto_1,//IMPORTE-TOT-1VT(Obligatorio)
                            $cant_registros_detalle,//NUM-TOT-COBROS
                            $cant_registros_detalle+2,//NUM-TOT- REGISTRO
                            '','','','','','','','','','','','','','','','');//filler1 al 16

            fputcsv($f, $fields, $delimiter); 
            // Move back to beginning of file 
            fseek($f, 0); 
            
            // Set headers to download file rather than displayed 
            header('Content-Type: text/csv'); 
            header('Content-Disposition: attachment; filename="' . $filename . '";'); 
            
            //output all remaining data on a file pointer 
            fpassthru($f); 
        } 
        exit;//return view('archivoDeuda.index'); 
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

    public function getSocio(Request $request)
    {     
        $socioNro = $request->input('socioNro');
       // DB::enableQueryLog();

        $socio = DB::table('lvl_socios')
                ->where('lvl_socios.socio_nro',$socioNro)
                ->join('lvl_personas','lvl_personas.id','lvl_socios.id_persona')
                ->first();
                
       // var_dump(DB::getQueryLog());
       return response()->json($socio);
        //return json_encode(array("socio" , $socio));
       
    }

    public function getSociopordni(Request $request)
    {     
        $dni = $request->input('dni');

        $socio = DB::table('lvl_socios')
                ->where('lvl_personas.dni',$dni)
                ->join('lvl_personas','lvl_personas.id','lvl_socios.id_persona')
                ->first();
                
       return response()->json($socio);
    }
}
