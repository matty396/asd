<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;


class MaintenanceController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['role:Supervisor'], []);
    }

    public function index()
    {
        \Artisan::call('optimize');
        return response()->json([
           'status' =>'success',
            'data' => [
               'status' =>'success',
               'message' => 'Maintenance mode is enabled',
            ],
        ]);
    }

}
