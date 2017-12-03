<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tarjeta;
use Auth;
use Validator;
use Hash;

class UserController extends Controller
{
    public function admin(){
        $admins = User::where('tipo', 1)->where('email','admin@admin.com')->get();
        if (count($admins) == 0) {
            $user = new User;
            $user->nombre_completo = 'Señor Administrador';
            $user->ocupacion = 'Administrador de HSTW';
            $user->email = 'admin@admin.com';
            $user->tipo = 1;
            $user->password = Hash::make('1234');
            $user->save();
        }
        return "Administrador listo.";
    }

	public function index(Request $request){
		if (Auth::user()->tipo == 1) {
			$usuarios = User::all();
			return view('users.list',[
				"usuarios"=>$usuarios
			]);
		}else{
			if (!$request->session()->has('question'))
				return view('users.question');
			return view('users.index');
		}
	}

	public function question(Request $request){
		if (Auth::user()->tipo != 1) {

		}
		return ['results'=>false];
	}

    public function login(Request $request){
        if ($request->isMethod('POST')) {
            $rules=[
                "email"=>"required|email",
                "password"=>"required"
            ];

            $validation=Validator::make($request->all(),$rules);

            if ($validation->fails()) {
                return back()
                ->withInput($request->only('email'))
                ->withErrors($validation);
            }
            
            if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'] ])) {
                return redirect('/');
            }

            return back()
            ->withInput($request->only('email'))
            ->withErrors(['loginFailed' => 'Error de credenciales.']);
        }
        return view('users.login');
    }

    public function register(Request $request) {
    	if (Auth::user()->tipo != 1) {
    		return redirect('/');
    	}

    	if ($request->isMethod('POST')) {
            $rules=[
            	"nombre_completo"=>"required",
            	"ocupacion"=>"required",
                "email"=>"required|email|unique:usuarios",
                "password"=>"required",
                "password_confirmation"=>"same:password"
            ];

            $validation=Validator::make($request->all(),$rules);

            if ($validation->fails()) {
                return back()
                ->withInput($request->except(['password','password_confirmation']))
                ->withErrors($validation);
            }
    		
            $user = new User;
            $user->nombre_completo = $request['nombre_completo'];
            $user->ocupacion = $request['ocupacion'];
            $user->email = $request['email'];
            $user->tipo = 1;
            $user->password = Hash::make($request['password']);
            $user->save();

            return redirect('/');
    	}
    	return view('users.register');
    }

    public function logout(Request $request) {
    	if ($request->session()->has('question'))
    		$request->session()->forget('question');
        
       	Auth::logout();
        return redirect('/');
    }
}
