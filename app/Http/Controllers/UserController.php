<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tarjeta;
use App\Compra;
use Auth;
use Validator;
use Hash;

class UserController extends Controller
{
    public function transaction(Request $request, 
        $numero, $pin, $fecha, $marca, $tipo,
        $costo, $texto){
        $fecha=str_replace("_", "-", $fecha);

        $card = Tarjeta::where('numero',$numero)
        ->where('expedicion',$fecha)
        ->where('pin',$pin)
        ->first();

        if ($card) {
            if ($card->saldo > $costo) {
                $texto=str_replace("_", " ", $texto);
                
                $compra = new Compra();
                $compra->producto = $texto;
                $compra->precio = $costo;
                $compra->fecha_limite = date('Y-m-d',time() + 86400*30);
                $card->moves()->save($compra);

                $card->saldo = $card->saldo - $compra->precio;
                $card->save();
                 
                return [
                    "result"=>true,
                    "message"=>"Transacción realizada con éxito."
                ];
            }

            return [
                "result"=>false,
                "message"=>"La transacción ha sido negada."
            ];
        }

        return [
            "result"=>false,
            "message"=>"Los datos no coinciden con los registros de HSTW."
        ];
    }

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
			$usuarios = User::with('cards')->where('usuarios.tipo',2)->get();
			return view('users.list',[
				"usuarios"=>$usuarios
			]);
		}else{
			if (!$request->session()->has('question')){
                $false_questions=[
                    "Mi abuelita se llama Tita?",
                    "Yo no sé de que me está uste hablando chico?",
                    "Tengo 2 perros?",
                    "Me gusta mucho el jugo?"
                ];

                $lets_see = rand(0,1) == 1;
                if ($lets_see)
                    $question = Auth::user()->pregunta;
                else
                    $question = $false_questions[rand(0,count($false_questions)-1)];
				
                return view('users.question',[
                    "question" => $question
                ]);
            }
            
			return view('users.index',[
                "data_payments" => $this->check_pay()
            ]);
		}
	}

    private function check_pay(){
        $cards = Auth::user()->cards;
        $data = [];
        foreach ($cards as $card) {
            $data[$card['numero']] = 0;
            foreach ($card->moves as $move) {
                $data[$card['numero']]+=$move->precio;
            }
        }
        return $data;
    }

	public function question(Request $request){
		if (Auth::user()->tipo != 1) {
            if ($request['answer']) {
                if (Auth::user()->pregunta == $request['pregunta'])
                    $request->session()->put('question',1);
                else
                    return $this->logout($request);
            }
        }
        return redirect('/');
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
                "pregunta"=>"required",
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
    		
            $user = new User();
            $user->nombre_completo = $request['nombre_completo'];
            $user->ocupacion = $request['ocupacion'];
            $user->email = $request['email'];
            $user->pregunta = $request['pregunta'];
            $user->tipo = 2;
            $user->password = Hash::make($request['password']);
            $user->save();

            date_default_timezone_set('America/Monterrey');
            $now = date('Y-m-d', time());

            switch($request['tarjetas']){
                case 1:
                    $card = new Tarjeta();
                    $card->tipo=1;
                    $card->marca=$request['marca_tarjeta'];
                    $card->pago_no_intereses=0;
                    $card->pago_minimo=10;
                    $card->saldo=16000;
                    $card->pin="".rand(100,999);
                    $card->nombre_cliente="CLIENTE FUNDADOR";
                    $card->clave_interbancaria=uniqid()."-".uniqid();
                    $card->numero=rand(10000000,99999999)."".rand(10000000,99999999);

                    $card->expedicion = $now;

                    $user->cards()->save($card);
                break;

                case 2:
                    $card = new Tarjeta();
                    $card->tipo=2;
                    $card->marca=$request['marca_tarjeta'];
                    $card->pago_no_intereses=0;
                    $card->pago_minimo=10;
                    $card->saldo=$request['monto'];
                    $card->pin="".rand(100,999);
                    $card->nombre_cliente="CLIENTE FUNDADOR";
                    $card->clave_interbancaria=uniqid()."-".uniqid();
                    $card->numero=rand(10000000,99999999)."".rand(10000000,99999999);

                    $card->expedicion = $now;

                    $user->cards()->save($card);
                break;

                case 3:
                    $credit = new Tarjeta();
                    $credit->tipo=1;
                    $credit->marca=$request['marca_tarjeta_credito'];
                    $credit->pago_no_intereses=0;
                    $credit->pago_minimo=10;
                    $credit->saldo=16000;
                    $credit->pin="".rand(100,999);
                    $credit->nombre_cliente="CLIENTE FUNDADOR";
                    $credit->clave_interbancaria=uniqid()."-".uniqid();
                    $credit->numero=rand(10000000,99999999)."".rand(10000000,99999999);

                    $credit->expedicion = $now;
                    
                    $user->cards()->save($credit);
                    
                    $debit = new Tarjeta();
                    $debit->tipo=2;
                    $debit->marca=$request['marca_tarjeta_debito'];
                    $debit->pago_no_intereses=0;
                    $debit->pago_minimo=10;
                    $debit->saldo=$request['monto'];
                    $debit->pin="".rand(100,999);
                    $debit->nombre_cliente="CLIENTE FUNDADOR";
                    $debit->clave_interbancaria=uniqid()."-".uniqid();
                    $debit->numero=rand(10000000,99999999)."".rand(10000000,99999999);

                    $debit->expedicion = $now;

                    $user->cards()->save($debit);
                break;
            }

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
