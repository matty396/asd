<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Search;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $proveedores = DB::table('lvl_proveedores as p')
                        ->orwhere('cuit','LIKE','%'.$search.'%')
                        ->orwhere('nombre_fantasia','LIKE','%'.$search.'%')
                        ->select('*')
                        ->paginate(15);     
        return view('proveedor.index',compact("proveedores","search"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("proveedor.create");
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
        
        $proveedor = Proveedor::create([
                    'id' => null,
                    'nombre_fantasia' => $request->nombre_fantasia,
                    'cuit' => $request->cuit,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'domicilio' => $request->domicilio,
                    'nro' => $request->nro,
                    'piso' => $request->piso,
                    'dpto' => $request->dpto,
                    'estado' => $request->estado,
                    'created_at' => now(),
                    'updated_at' => null,
        ]);

        $proveedores = DB::table('lvl_proveedores as p')
                            ->select('*')
                            ->paginate(15);     
        return view('proveedor.index',compact("proveedores"));
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
        $proveedor = Proveedor::findOrFail($id);
        return view("proveedor.edit")->with('proveedor', $proveedor);
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
            'nombre_fantasia' => $request->nombre_fantasia,
            'cuit' => $request->cuit,
            'celular' => $request->celular,
            'email' => $request->email,
            'domicilio' => $request->domicilio,
            'nro' => $request->nro,
            'piso' => $request->piso,
            'dpto' => $request->dpto,
            'estado' => $request->estado,
            'created_at' => now(),
            'updated_at' => null,
        ];
        
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($datos);

        $proveedores = DB::table('lvl_proveedores as p')
        ->select('*')
        ->paginate(15);     

        return view('proveedor.index')->with('proveedores',$proveedores);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Proveedor::destroy($id);
        $proveedores = DB::table('lvl_proveedores as p')
        ->select('*')
        ->paginate(15);     
        
        return view('proveedor.index')->with('proveedores',$proveedores);
    }

    public function getProveedores(Request $request){
        $search = $request->get('search');

        if($search == ''){
           $proveedores = DB::table('lvl_proveedores as c')
                                ->select('c.id','c.cuit',
                                        'c.nombre_fantasia' ,'c.celular','c.email'
                                    )
                                ->where('c.nombre_fantasia', 'like', '%' .$search . '%') 
                                ->get();  
        }else{
            
//DB::enableQueryLog();
           $proveedores = DB::table('lvl_proveedores as c')
                                ->select('c.id','c.nombre_fantasia as nombre_fantasia' ,
                                        'c.cuit','c.celular','c.email')
                                ->where('nombre_fantasia', 'like', '%' .$search . '%') 
                                ->get();
            //$quries = DB::getQueryLog();
        //var_dump($quries);die;  
                                
                               
                                //echo $clientes;die;
                               // echo 'apellidos_nombres', 'like', '\"%' .$search . '%\"';die;
        }
  
        $response = array();
        foreach($proveedores as $proveedor){
           $response[] = array(
                "id"=>$proveedor->id,
                "label"=>$proveedor->nombre_fantasia
           );
        }
        return response()->json($response); 
     } 
}
