<?php

namespace App\Http\Controllers;

use App\Models\Mercaderia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MercaderiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mercaderias = DB::table('lvl_mercaderias as m')
                    ->select('*')
                    ->paginate(15);     
        return view('mercaderia.index',compact("mercaderias"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("mercaderia.create");
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
        $mercaderia = Mercaderia::create([
                    'id' => null,
                    'codigo' => $request->codigo,
                    'descripcion' => $request->descripcion,
                    'alto' => number_format(floatval($request->alto),2,'.',''),
                    'ancho' => number_format(floatval($request->ancho),2,'.',''),
                    'profundidad' => number_format(floatval($request->profundidad),2,'.',''),
                    'peso' => number_format(floatval($request->peso),2,'.',''),
                    'unidad_peso' => $request->unidad_peso,
                    'unidad_medida' => $request->unidad_medida,
                    'precio' => $request->precio,
                    'created_at' => now(),
                    'updated_at' => null,
        ]);

        $mercaderias = DB::table('lvl_mercaderias as m')
                    ->select('*')
                    ->paginate(15);     

        return redirect()->route('mercaderia.index')->with('mercaderia', $mercaderias);
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
        $mercaderia = DB::table('lvl_mercaderias as m')
        ->select('m.*')
        ->where('m.id',$id)
        ->first();   

        return view("mercaderia.edit")->with('mercaderia', $mercaderia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //var_dump($request);echo $id;die;
        $datos = [
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'alto' => number_format(floatval($request->alto),2,'.',''),
            'ancho' => number_format(floatval($request->ancho),2,'.',''),
            'profundidad' => number_format(floatval($request->profundidad),2,'.',''),
            'peso' => number_format(floatval($request->peso),2,'.',''),
            'unidad_peso' => $request->unidad_peso,
            'unidad_medida' => $request->unidad_medida,
            'precio' => $request->precio,            
            'created_at' => now(),
            'updated_at' => null,
        ];
       
        $mercaderia = Mercaderia::findOrFail($request->id);
        $mercaderia->update($datos);

        $mercaderias = DB::table('lvl_mercaderias as m')
                    ->select('*')
                    ->paginate(15);     

        return redirect()->route('mercaderia.index')->with('mercaderias', $mercaderias);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Mercaderia::destroy($id);

        $mercaderias = DB::table('lvl_mercaderias as m')
                    ->select('*')
                    ->paginate(15);     

        return redirect()->route('mercaderia.index')->with('mercaderias', $mercaderias);
    }

    public function getByCodigo(Request $request)
    {     
        $codigo = $request->input('codigo');
        //DB::enableQueryLog();
        $mercaderia = DB::table('lvl_mercaderias as m')
                        ->where('m.codigo',$codigo)
                        ->select('*')
                        ->first();
                
        //var_dump(DB::getQueryLog());die;
       return response()->json($mercaderia);
        //return json_encode(array("socio" , $socio));
       
    }

    public function getMercaderias(Request $request){
        $search = $request->get('search');

        if($search == ''){
           $mercaderias = Mercaderia::orderby('descripcion','asc')->select('id','descripcion','peso')->limit(5)->get();
        }else{
           $mercaderias = Mercaderia::orderby('descripcion','asc')->select('id','descripcion','peso')->where('descripcion', 'like', '%' .$search . '%')->limit(5)->get();
        }
  
        $response = array();
        foreach($mercaderias as $mercaderia){
           $response[] = array(
                "id"=>$mercaderia->id,
                "label"=>$mercaderia->descripcion.' - '.$mercaderia->peso,
                "precio"=>$mercaderia->precio
           );
        }
        return response()->json($response); 
     } 

     public function getMercaderiaCodigo(Request $request)
     {     
         $descripcion = $request->input('descripcion');
         $mercaderia = DB::table('lvl_mercaderias as m')
                    ->where('descripcion', '=',$descripcion)
                    ->select('m.id as id', 'm.descripcion as descripcion','m.codigo','m.precio')
                    ->get();

        return response()->json($mercaderia[0]);
     }
     
}
