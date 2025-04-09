<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $buscar = $request->get('buscar');
        $criterio = $request->get('criterio');

        if (is_null($buscar) || $buscar === '') {
            $registros = Role::select('roles.*')
                ->orderBy('roles.name', 'asc')
                ->paginate(100);
        } else {
            $registros = Role::select('roles.*')
                ->where($criterio, 'like', '%' . $buscar . '%')
                ->orderBy('roles.name', 'asc')
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
        ];
    }

    public function create(Request $request): JsonResponse
    {
        $roles = Role::create(['name' => $request->name]);
        return response()->json($roles->toArray(), 200);
    }

    public function show($id): JsonResponse
    {
        $role = Role::findOrFail($id)->toArray();
        if (!$role) {
            return response()->json([], 404);
        }
        return response()->json(
            [
                'registros' => $role,
            ],
            200
        );
    }

    public function update($id, Request $request): JsonResponse
    {
        $role = Role::findOrFail($id)->update(['name' => $request->name]);
        if (!$role) {
            return response()->json([], 404);
        }
        return response()->json($role, 200);
    }

    public function destroy($id): JsonResponse
    {
        $role = Role::findOrFail($id)->delete();
        if (!$role) {
            return response()->json([], 404);
        }
        return response()->json('Deleted Successfully', 200);
    }

    public function assignPermissionToRole($role, $permission): JsonResponse
    {
        $roles = Role::where(['name' => $role])->first();

        if (!$roles) {
            return response()->json([], 404);
        }
        $roles->givePermissionTo($permission);
        return response()->json($roles, 200);
    }

    public function assignRoleToUser($userId, $role): JsonResponse {
        $user = User::find($userId);
        if (!$user) {
            return response()->json([], 404);
        }
        $user->assignRole($role);
        return response()->json($user, 200);
    }
}
