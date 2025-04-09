<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = DB::table('lvl_clientes as c')
                    ->join('lvl_personas as p','p.id','c.persona_id')
                    ->select('p.id as persona_id','c.id as cliente_id','p.apellidos','p.nombres','p.dni','p.celular','p.email',
                            DB::raw('DATE_FORMAT(p.fecha_nacimiento,"%d-%m-%Y") as fecha_nacimiento')
                            ,'p.domicilio', 'p.nro', 'p.piso', 'p.dpto'
                        )
                    ->paginate(15);     
        return view('cliente.index',compact("clientes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("cliente.create");
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
        
        $persona = Persona::create([
                    'id' => null,
                    'apellidos' => $request->apellidos,
                    'nombres' => $request->nombres,
                    'dni' => $request->dni,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'domicilio' => $request->domicilio,
                    'nro' => $request->nro,
                    'piso' => $request->piso,
                    'dpto' => $request->dpto,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'created_at' => now(),
                    'updated_at' => null,
        ]);

        $clientes = DB::table('lvl_clientes as c')
                    ->join('lvl_personas as p','p.id','c.persona_id')
                    ->select('p.*')
                    ->paginate(15);   

        Cliente::create([
            'id' => null,
            'persona_id' => $persona->id,
            'estado' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        return redirect()->route('cliente.index')->with('clientes', $clientes);
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
    public function edit($cliente_id)
    {
        $cliente = DB::table('lvl_clientes as c')
                    ->join('lvl_personas as p','p.id','c.persona_id')
                    ->select('p.id as persona_id','c.id as cliente_id','p.apellidos','p.nombres','p.dni','p.celular','p.email',
                            DB::raw('DATE_FORMAT(p.fecha_nacimiento,"%Y-%m-%d") as fecha_nacimiento'),
                            'p.domicilio', 'p.nro', 'p.piso', 'p.dpto'
                        )
                    ->where('c.id',$cliente_id)
                    ->first();    
        

        return view("cliente.edit")->with('cliente', $cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cliente_id)
    {
        //var_dump($request);echo $id;die;
        $datos = [
            'apellidos' => $request->apellidos,
            'nombres' => $request->nombres,
            'dni' => $request->dni,
            'celular' => $request->celular,
            'email' => $request->email,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'domicilio' => $request->domicilio,
            'nro' => $request->nro,
            'piso' => $request->piso,
            'dpto' => $request->dpto,
            'updated_at' => now(),
        ];
        
        $persona = Persona::findOrFail($request->persona_id);
        $persona->update($datos);

        $clientes = DB::table('lvl_clientes as c')
                    ->join('lvl_personas as p','p.id','c.persona_id')
                    ->select('p.*')
                    ->first();

        return redirect()->route('cliente.index')->with('clientes', $clientes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::where('persona_id',$id)->first();
        Cliente::destroy($id);
        Persona::destroy($cliente->id);
        

        $clientes = DB::table('lvl_clientes as c')
                    ->join('lvl_personas as p','p.id','c.persona_id')
                    ->select('p.*')
                    ->paginate(15); 

        return redirect()->route('cliente.index')->with('clientes', $clientes);
        //return view('persona.index',compact("personas"));
    }

    public function getClientes(Request $request){
        $search = $request->get('search');

        if($search == ''){
           $clientes = DB::table('lvl_clientes as c')
                                ->join('lvl_personas as p','p.id','c.persona_id')
                                ->select('p.id as id',
                                        DB::raw('CONCAT(p.apellidos",", p.nombres) as apellidos_nombres') ,'p.dni','p.celular','p.email',
                                        DB::raw('DATE_FORMAT(p.fecha_nacimiento,"%d-%m-%Y") as fecha_nacimiento')
                                    )
                                ->where('apellidos_nombres', 'like', '%' .$search . '%') 
                                ->get();  
        }else{
           $clientes = DB::table('lvl_clientes as c')
                                ->join('lvl_personas as p','p.id','c.persona_id')
                                ->select('p.id as id',
                                        DB::raw('CONCAT(p.apellidos,\' \', p.nombres) as apellidos_nombres') ,
                                        'p.dni','p.celular','p.email',
                                        DB::raw('DATE_FORMAT(p.fecha_nacimiento,\'%d-%m-%Y\') as fecha_nacimiento')
                                    )
                                ->having('apellidos_nombres', 'like', "%$search%") 
                                ->get();  
                                
                               
                                //echo $clientes;die;
                               // echo 'apellidos_nombres', 'like', '\"%' .$search . '%\"';die;
        }
  
        $response = array();
        foreach($clientes as $cliente){
           $response[] = array(
                "id"=>$cliente->id,
                "label"=>$cliente->apellidos_nombres
           );
        }
        return response()->json($response); 
     } 
}
