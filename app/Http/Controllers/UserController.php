<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        //$headers = [];
        //return response()->json(User::all(), 200, $headers);
        return view('users.index')->with('users', User::all());;
    }

    public function create(){
       // return "se muestra el formulario con la opción de crear";
       //User::create
       $user = new User();
       return view('users.create')->with('user', $user);
    }

    public function store(){
        $data = request()->all();
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'timezone' => $data['timezone'],
        ]);
    }

    public function show($id){
        $id = (integer) $id;
        $cod = 200;
        $headers = [];
        $resp = [];
        try{
            $id = User::find($id);
            if(strtoupper($id) == NULL){
                $resp = ['response' => 'No existe ese usuario']; 
            }
        }
        catch (Throwable $t){
            $resp = ['error' => $t];
            $cod = 404;            
        }
        return response()->json($resp, $cod, $headers); 
    }
}
