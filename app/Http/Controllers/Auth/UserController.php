<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if (is_null($buscar) || $buscar === '') {
            $registros = User::select('users.*')
                ->orderBy('users.name', 'desc')
                ->paginate(100);
        } else {
            $registros = User::select('users.*')
                ->where($criterio, 'like', '%' . $buscar . '%')
                ->orderBy('users.name', 'desc')
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
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json($user->toArray(), 200);
    }

    public function show($id)
    {
        $registros = User::select('users.*')
            ->where('users.id', '=', $id)
            ->orderBy('users.id', 'desc')
            ->get();
        return [
            'registros' => $registros,
        ];
    }

    public function update($id, Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $user = Auth::user()->update($request->except(['_token', 'email']));
        if ($user) {
            $message = "Account updated successfully.";
            $status = 200;
        } else {
            $message = "Error while saving. Please try again.";
            $status = 403;
        }
        return response()->json([$message], $status);
    }

    public function destroy($id): JsonResponse
    {
        $user = Role::findOrFail($id)->delete();
        if (!$user) {
            return response()->json([], 404);
        }
        return response()->json($user, 200);
    }

}
