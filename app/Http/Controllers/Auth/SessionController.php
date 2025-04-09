<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create() {
        return view("auth.login");
    }    

    public function store() {
        if(Auth()->attempt(request(['email','password'])) == false){
            return back()->withErrors(['message'=>'El correo o la contraseña es incorrecta']);
        }

       return view('/welcome');
    }

    public function logout(){
        Auth()->logout();
        return redirect()->to('/');
    }
}
