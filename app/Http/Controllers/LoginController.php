<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()) return redirect()->route('test.index');
        return view('login.index');
    }
    public function entrar(Request $req)
    {
        $dados = $req->all();
        $remember = isset($dados['remember']);
        if(Auth::attempt(['email'=>$dados['email'],'password'=>$dados['senha']], $remember)){
            return redirect()->route('test.index');
        }
        return view('login.index')
            ->with('isIncorrectCredencials', true);
    }
    public function sair()
    {
        Auth::logout();
        return redirect()->route('login.index');
    }
}
