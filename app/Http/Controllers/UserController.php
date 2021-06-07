<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }
    
    public function store(Request $req)
    {
        $dados = $req->all();
        // criamos o novo user
        $user = User::where('email', $dados['email'])->first();
        // se usuário existe
        if ($user !== null){
            return view('user.create')
                ->with('isIncorrectCredencials', true);
        }
        
        $pass = 'dN@deV3nD@$';
        $user = new User(['email' => $dados['email'],
            'name' => $dados['name'], 
            'password' => bcrypt($pass),
            'type' => 'user'
        ]);
        // tudo ok? redireciona
        return redirect()->route('login.index');
    }
}
