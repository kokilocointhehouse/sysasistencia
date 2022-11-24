<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login()
    {
        $credentials = $this->validate(request(), [
            'NumDocumento' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            if (auth()->user()->Estado == 'ACTIVO') {
                if (auth()->user()->TipoUsuario =="PERSONAL"){
                    return redirect()->route('registro.index');
                }elseif(auth()->user()->TipoUsuario =="ADMINISTRADOR"){
                    return redirect()->route('dashboard-administrador.index');
                }else{
                    Auth::logout();
                    return redirect('/')->with('flash','Su rol no se encuentra definido, por favor COMUNIQUESE con el ADMINISTRADOR!');
                }
            }else{
                Auth::logout();
                return redirect('/')->with('flash','Su cuenta se encuentra INACTIVA, por favor COMUNIQUESE con el ADMINISTRADOR!');
            }

        }
        return back()
            ->withErrors(['NumDocumento' => trans('auth.failed')])
            ->withInput(request(['NumDocumento']));
    }



    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        if (isset(auth()->user()->nombres)) {
            Auth::logout();
        }
    }


    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
