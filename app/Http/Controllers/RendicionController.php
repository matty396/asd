<?php

namespace App\Http\Controllers;

use App\Models\Rendicion;
use App\Models\RendicionDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Http\Controllers\File;
use Illuminate\Support\Facades\DB;

//use ZipStream\File;
class RendicionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rendiciones = Rendicion::select('*')->paginate(10);
        return view('rendicion.index')->with('rendiciones',$rendiciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rendicion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //if ($request->input('submit') != null ){

            $file = $request->file('file');
      
            // File Details 
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
      
            // Valid File Extensions
            $valid_extension = array("zip");
            echo $filename."<br>";
            echo $extension."<br>";
            echo $tempPath."<br>";
            echo $fileSize."<br>";
            echo $mimeType."<br>";
            $maxFileSize = 900;
            if(in_array(strtolower($extension),$valid_extension)){
                //Unzip file;
                //$dir_path = date('Y') . '/' . date('m') . '/';
                
                $zip = new ZipArchive();
                //$file_new_path = $file->storeAs($dir_path . 'zip' , $filename, 'local');
                $zipFile = $zip->open($request->file('file'));
                if ($zipFile === TRUE) {
                    $zip->extractTo(storage_path());//disk('local')->storage::pathinfo()); 
                    $zip->close();
                }
                //abrir el archivo CSV
                $filename_array = explode(".",$filename);
                $file_txt = storage_path($filename_array[0].".txt");
                $file = fopen($file_txt, "r");
                $all_data = array();
                $cont = 0;
                $header_id = 0;
                $linea = "";
                while(!feof($file)) {
                    $linea = fgets($file);
                    
                    if($cont == 0) {
                      /*echo substr($linea,0,6). "<br>";//Tipo de Registro HEADER
                      echo substr($linea,6,3). "<br>";//Código de Botón ante BCRA
                      echo substr($linea,9,8). "<br>";//Fecha de Proceso
                      echo substr($linea,17,8). "<br>";//Fecha de Envio
                      echo substr($linea,25,5). "<br>";//Nro de Lote*/
                      $tipo_registro =  substr($linea,0,6);//Tipo de Registro HEADER
                      $cod_boton_bcra =  substr($linea,6,3);//Código de Botón ante BCRA
                      $fecha_proceso = substr($linea,9,8);//Fecha de Proceso
                      $fecha_envio =  substr($linea,17,8);//Fecha de Envio
                      $nro_lote =  substr($linea,25,5);
                      $header = array(
                            "tipo_registro" => $tipo_registro,
                            "cod_boton_bcra" => $cod_boton_bcra,
                            "fecha_proceso" => $fecha_proceso,
                            "fecha_envio" => $fecha_envio,
                            "nro_lote" => $nro_lote,
                            "created_at"=>now(),
                            "updated_at"=> now(),
                            );
                            Rendicion::insert($header);
                            $header_id = DB::getPdo()->lastInsertId();
                            //echo fgets($file). "<br>";
                    }else{
                        if(substr($linea,0,7) == "TRAILER"){
                            /*echo substr($linea,0,7). "<br>";//Tipo de Registro TRAILER
                            echo substr($linea,7,8). "<br>";//Cantidad de registros
                            echo substr($linea,15,13). "<br>";//Importe
                            echo substr($linea,28,8). "<br>"; //Cantidad de TRX*/
                            $tipo_registro_2 = substr($linea,0,7);//Tipo de Registro TRAILER
                            $cant_registros = substr($linea,7,8);//Cantidad de registros
                            $importe = substr($linea,15,13);//Importe
                            $cant_trx = substr($linea,28,8);
                            $trailer = array(
                                "tipo_registro_pie" => $tipo_registro_2,
                                "cant_registros" => $cant_registros,
                                "importe" => $importe,
                                "cant_trx" => $cant_trx,
                                "created_at"=>now(),
                                "updated_at"=> now(),
                                );
                                $rendicion = Rendicion::findOrFail($header_id);
                                $rendicion->update($trailer);
                        }else{
                           /* $datos_relleno = substr($linea,0,8);//Datos + Relleno(3)
                            $cod_boton_bcra = substr($linea,8,4);//Código de Botón Ante BCRA
                            $r = substr($linea,12,1). "<br>";//R
                            $cod_terminal = substr($linea,13,5). "<br>";//Código Terminal
                            $adicional_1 = substr($linea,18,10). "<br>";//Adicional 1
                            $cod_sucursal = substr($linea,28,4). "<br>";//Código Sucursal 2222
                            $relleno = substr($linea,32,8). "<br>";//Relleno
                            $transaccion = substr($linea,40,8). "<br>";//Transacción
                            $cod_operacion = substr($linea,48,2). "<br>";//Código Operación
                            $tipo_transaccion = substr($linea,50,2). "<br>";//Tipo de transacción
                            $relleno_2 = substr($linea,52,2). "<br>";//Relleno
                            $cod_ente = substr($linea,54,4). "<br>";//Código Ente
                            $adicional_2 = substr($linea,58,19). "<br>";//Adicional 2
                            $importe = substr($linea,77,12). "<br>";//Importe
                            $adicional_3 = substr($linea,88,11). "<br>";//Adicional 3
                            $adicional_4 = substr($linea,99,11). "<br>";//Adicional 4
                            $moneda = substr($linea,110,1). "<br>";//Moneda 0 pesos 1 dolares
                            $adicional_5 = substr($linea,111,4). "<br>";//Adicional 5
                            $relleno_3 = substr($linea,115,3). "<br>";//Relleno
                            $relleno_4 = substr($linea,118,2). "<br>";//Relleno
                            $relleno_5 = substr($linea,120,3). "<br>";//Relleno
                            $id_comercio = substr($linea,123,6). "<br>";//Id_Comercio
                            $hora_transaccion = substr($linea,129,6). "<br>";//Hora de la transaccion HHMMSS
                            $relleno_6 = substr($linea,135,3). "<br>";//Relleno
                            $relleno_7 = substr($linea,138,3). "<br>";//Relleno
                            $relleno_8 = substr($linea,141,4). "<br>";//Relleno
                            $fecha_liquidacion = substr($linea,145,8). "<br>";//Fecha de liquidación
                            $adicional_6 = substr($linea,153,8). "<br>";//Adicional 6
                            $relleno_9 = substr($linea,161,3). "<br>";//Relleno
                            $cod_barra = substr($linea,164,60). "<br>";//Código de Barra
                            $fecha_pago = substr($linea,224,6). "<br>";//Fecha Pago
                            $modo_pago = substr($linea,230,1). "<br>";//Modo de Pago
                            $adicional_7 = substr($linea,231,7). "<br>";//Adicional 7
                            $id_trx_proc_pago = substr($linea,238,9). "<br>";//ID de transacción procesador de pago
                            $forma_pago = substr($linea,247,2). "<br>";//Forma Pago 90 tarjeta debito 80 credito 60 debin
                            $adicional_8 = substr($linea,249,4). "<br>";//Adicional 8
                            $adicional_9 = substr($linea,253,3). "<br>";//Adicional 9
                            $adicional_10 = substr($linea,256,15). "<br>";//Adicional 10
                            $adicional_11 = substr($linea,271,8). "<br>";//Adicional 11
                            $id_trx_ente = substr($linea,279,150). "<br>";//ID Transacción del ente
                            $clave_1 = substr($linea,429,50). "<br>";//Clave 1
                            $clave_2 = substr($linea,479,50). "<br>";//Clave 2
                            $clave_3 = substr($linea,529,50). "<br>";//Clave 3
                            $descripcion = substr($linea,579,50). "<br>";//Descripción
                        */
                    
                    //Guardar Datos = 
                    $detalle_data = array(
                            "datos_relleno" => substr($linea,0,8),//Datos + Relleno(3)
                            "header_id" => $header_id,//Datos + Relleno(3)
                            "cod_boton_bcra" => substr($linea,8,4),//Código de Botón Ante BCRA
                            "r" => substr($linea,12,1),//R
                            "cod_terminal" => substr($linea,13,5),//Código Terminal
                            "adicional_1" => substr($linea,18,10),//Adicional 1
                            "cod_sucursal" => substr($linea,28,4),//Código Sucursal 2222
                            "relleno_1" => substr($linea,32,8),//Relleno
                            "transaccion" => substr($linea,40,8),//Transacción
                            "cod_operacion" => substr($linea,48,2),//Código Operación
                            "tipo_transaccion" => substr($linea,50,2),//Tipo de transacción
                            "relleno_2" => substr($linea,52,2),//Relleno
                            "cod_entidad" => substr($linea,54,4),//Código Ente
                            "adicional_2" => substr($linea,58,19),//Adicional 2
                            "importe" => substr($linea,77,12),//Importe
                            "adicional_3" => substr($linea,88,11),//Adicional 3
                            "adicional_4" => substr($linea,99,11),//Adicional 4
                            "moneda" => substr($linea,110,1),//Moneda 0 pesos 1 dolares
                            "adicional_5" => substr($linea,111,4),//Adicional 5
                            "relleno_3" => substr($linea,115,3),//Relleno
                            "relleno_4" => substr($linea,118,2),//Relleno
                            "relleno_5" => substr($linea,120,3),//Relleno
                            "id_comercio" => substr($linea,123,6),//Id_Comercio
                            "hora_transaccion" => substr($linea,129,6),//Hora de la transaccion HHMMSS
                            "relleno_6" => substr($linea,135,3),//Relleno
                            "relleno_7" => substr($linea,138,3),//Relleno
                            "relleno_8" => substr($linea,141,4),//Relleno
                            "fecha_liquidacion" => substr($linea,145,8),//Fecha de liquidación
                            "adicional_6" => substr($linea,153,8),//Adicional 6
                            "relleno_9" => substr($linea,161,3),//Relleno
                            "cod_barra" => substr($linea,164,60),//Código de Barra
                            "fecha_pago" => substr($linea,224,6),//Fecha Pago
                            "modo_pago" => substr($linea,230,1),//Modo de Pago
                            "adicional_7" => substr($linea,231,7),//Adicional 7
                            "id_trx_proc_pago" => substr($linea,238,9),//ID de transacción procesador de pago
                            "forma_pago" => substr($linea,247,2),//Forma Pago 90 tarjeta debito 80 credito 60 debin
                            "adicional_8" => substr($linea,249,4),//Adicional 8
                            "adicional_9" => substr($linea,253,3),//Adicional 9
                            "adicional_10" => substr($linea,256,15),//Adicional 10
                            "adicional_11" => substr($linea,271,8),//Adicional 11
                            "id_trx_entidad" => substr($linea,279,150),//ID Transacción del ente
                            "clave_1" => substr($linea,429,50),//Clave 1
                            "clave_2" => substr($linea,479,50),//Clave 2
                            "clave_3" => substr($linea,529,50),//Clave 3
                            "descripcion" => substr($linea,579,50),//Descripción
                        //"created_at"=>now(),
                        //"updated_at"=> now(),
                        
                        );
                        if ($detalle_data["datos_relleno"]=="") continue;
                        RendicionDetalle::insert($detalle_data);
                        
                        }
                }
                $cont++;
            }
                
            }
            $rendiciones = Rendicion::select('*')->paginate(10);
            return view("rendicion.index",compact("rendiciones"));
        }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
