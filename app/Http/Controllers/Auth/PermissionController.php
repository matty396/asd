<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $permissions = Permission::paginte(5);
        return view('permissions.index',compact('permissions'));
       /* $buscar = $request->get('buscar');
        $criterio = $request->get('criterio');

        if (is_null($buscar) || $buscar === '') {
            $registros = Permission::select('permissions.*')
                ->orderBy('permissions.name', 'asc')
                ->paginate(100);
        } else {
            $registros = Permission::select('permissions.*')
                ->where($criterio, 'like', '%' . $buscar . '%')
                ->orderBy('permissions.name', 'asc')
                ->paginate(100);
        }

        return [
            'pagination' => [
                'total' => $registros->total(),
                'current_page' => $registros->currentPage(),
                'per_page' => $registros->perPage(),
                'last_page' => $registros->lastPage(),
                'from' => $registros->firstItem(),
                'to' => $registros->lastItem(),
            ],
            'registros' => $registros,
        ];*/

    }

    public function create(Request $request): JsonResponse
    {
        $permission = Permission::create(['name' => $request->name]);
        return response()->json($permission->toArray(), 200);
    }

    public function show($id): JsonResponse
    {
        $permission = Permission::findOrFail($id)->toArray();
        if (!$permission) {
            return response()->json([], 404);
        }
        return response()->json(
            [
                'registros' => $permission,
            ],
            200
        );
    }

    public function update($id, Request $request): JsonResponse
    {
        $permission = Permission::findOrFail($id)->update(['name' => $request->name]);
        if (!$permission) {
            return response()->json([], 404);
        }
        return response()->json($permission, 200);
    }

    public function destroy($id): JsonResponse
    {
        $permission = Permission::findOrFail($id)->delete();
        if (!$permission) {
            return response()->json([], 404);
        }
        return response()->json('Deleted Successfully', 200);
    }

}
