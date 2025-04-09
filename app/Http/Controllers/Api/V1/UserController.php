<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

// Spatie
// use Spatie\Permission\Traits\HasRoles;


class UserController extends ApiController
{
    /**
     * Control de permisos
     */
    function __construct()
    {
        /*
        $this->middleware('can:users.index')->only('index');
        $this->middleware('can:users.create')->only('create', 'store');
        $this->middleware('can:users.edit')->only('edit', 'update');
        $this->middleware('can:users.destroy')->only('destroy');
        */
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        //
        $criterio = filled($request->criterio) ? $request->criterio : 'name';   // criterio por defecto
        $orden = filled($request->orden) ? $request->orden : 'name';   // orden por defecto
        $request->merge([
            'criterio' => $criterio,
            'orden' => $orden,
        ]);

        return $this->getListAll($request, $user);    // ApiController
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->merge([
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
        ]);

        // validar
        $rules = [
            'name' => 'required|string|min:3|max:100|unique:users,name',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',  // |confirmed
        ];
        Request()->validate($rules, User::$messages);

        $user = User::create($request->except(['roles']));  // Crear User
        if (blank($request->roles)) {
            $user->assignRole('Usuario');  // Rol por defecto
        } else {
            $user->roles()->sync($request->roles);  // Actualizar roles asignados
        } // ( blank($request->roles) )

        $user->roles = $user->roles()->get();   // Agregar roles al Objeto

        return $this->sendResponse($user->toArray(), 'Registro creado exitosamente!', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        $user->roles = $user->roles()->get();   // Agregar roles al Objeto

        return $this->sendResponse($user->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|min:3|max:100|unique:users,name,' . $user->id,
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'id_vigente' => 'nullable|integer|exists:empresas,id',
        ];

        $request->merge(['email' => strtolower($request->email)]);

        // validar y grabar nueva clave
        if (filled($request->new_password)) {
            $request->merge(['password' => bcrypt($request->new_password)]);
            $rules['password'] = 'required|string|min:8';   // validate
        }

        // validar
        Request()->validate($rules, User::$messages);

        $user->update($request->except(['roles'])); // Actualizar User

        if (filled($request->roles)) {
            $user->roles()->sync($request->roles);  // Actualizar roles asignados
        } // ( blank($request->roles) )

        $user->roles = $user->roles()->get();   // Agregar roles al Objeto

        return $this->sendResponse($user->toArray(), 'registro actualizado exitosamente!');
    }

    /**
     *
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();

        return $this->sendResponse(null, 'Registro borrado!');
    }

    /**
     * [ajax]
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function ajax(Request $request, User $user)
    {
        //
        $criterio = filled($request->criterio) ? $request->criterio : 'name';   // criterio por defecto
        $orden = filled($request->orden) ? $request->orden : 'name';   // orden por defecto
        $request->merge([
            'criterio' => $criterio,
            'orden' => $orden,
        ]);

        return $this->getListAjax($request, $user); // ApiController
    }


}
