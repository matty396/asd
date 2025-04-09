<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $query = DB::table('lvl_ventas_detalle as vd')
                ->join('lvl_ventas as v','v.id','=', 'vd.venta_id')
                ->join('lvl_mercaderias as m','vd.mercaderia_id','=', 'm.id')
            
                ->select('m.id as mercaderia_id', 'm.descripcion as descripcion',
                    'm.peso as peso',
                    DB::raw('sum(vd.cantidad) as cantidad'))
                    ->groupBy('m.id','m.descripcion','m.peso')
                //->where('v.fecha >= 2023-01-01')
                //->where('v.fecha <= 2023-11-01')    
                ->orderBy('cantidad','desc')     ; 
            
        $results_ventas =  $query->get();

        $data = [];
        foreach($results_ventas as $value){
            $data['label'][] = $value->descripcion;
            $data['data'][] = $value->cantidad;
        }
        $data['data'] = json_encode($data);

        //Reporte Cierre de Caja
        $query = DB::table('lvl_caja as c')
        ->select('c.id as caja_id','c.total',
                    DB::raw('DATE_FORMAT(c.fecha_desde,"%d-%m-%Y") as fecha_desde')  )
        //->where('v.fecha >= 2023-01-01')
        //->where('v.fecha <= 2023-11-01')    
        ->orderBy('c.fecha_desde','desc')     ; 
            
        $results_caja =  $query->get();

        $dataVentas = [];
        foreach($results_caja as $value){
            $dataVentas['label'][] = $value->fecha_desde;
            $dataVentas['data'][] = $value->total;
        }
        $dataVentas['data'] = json_encode($dataVentas);
        //dd($data);
        //dd($dataVentas);

        //Reporte Stock
        $query = DB::table('lvl_stock as s')
        ->join('lvl_mercaderias as m','m.id','=','s.mercaderia_id')
        ->select('*');
            
        $results_stock =  $query->get();

        $dataStock = [];
        foreach($results_stock as $value){
            $dataStock['label'][] = $value->descripcion;
            $dataStock['data'][] = $value->cantidad;
        }
        $dataStock['data'] = json_encode($dataStock);
        //dd($data);
        //dd($dataVentas);
        return view('/welcome')->with('data',$data)->with('dataVentas',$dataVentas)
                                ->with('dataStock',$dataStock);
    }
}
