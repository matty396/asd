<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        dd($request->all());
        dd($next);
        echo "autenti";var_dump(Auth::guard('web')->attempt( ['email'=>$request->email,'password'=>$request->password]));die;
        if (Auth::check()) {echo "si";die;
            // El usuario está autenticado, permite el acceso
            return $next($request);
        }

        // El usuario no está autenticado, redirige a la página de inicio de sesión
        return redirect('auth2/login');
    }
}
