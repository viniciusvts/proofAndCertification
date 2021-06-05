<?php

namespace App\Http\Controllers;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;

use Illuminate\Http\Request;
use Auth;

class TestController extends Controller
{
    public function test()
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $tests = Test::paginate(10);
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        return view('test.index')
            ->with('tests', $tests)
            ->with('isAdmin', $isAdmin);
    }
    
    public function create()
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        if($isAdmin){
            return view('test.create');
        }
        return redirect()->route('test.index');
    }
    
    public function store(Request $req)
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        // se não é admin, redireciona
        if(!$isAdmin) return redirect()->route('test.index');
        // se é admin inserimos no banco
        $dados = $req->all();
        // criamos o novo teste
        $test = new Test;
        $test->title = $dados['title'];
        $test->save();
        foreach ($dados['question'] as $q) {
            $question = new Question;
            $question->statement = $q['statement'];
            $test->questions()->save($question);
            $test->refresh();
            foreach ($q['answer'] as $a) {
                $answer = new Answer;
                $answer->option = $a['option'];
                $answer->isCorrect = isset($a['isCorrect']);
                $question->answers()->save($answer);
                $question->refresh();
            }
        }
        // tudo ok? redireciona
        return redirect()->route('test.index');
        
    }
    
    public function update(Request $req, $id)
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        // se não é admin, redireciona
        if(!$isAdmin) return redirect()->route('test.index');
        // se é admin primeiro apagamos as relações no banco
        $test = Test::find($id);
        $questions = $test->questions;
        foreach ($questions as $question) {
            $answers = $question->answers;
            foreach ($answers as $answer) {
                $answer->delete();
            }
            // depois de deletar cada resposta deleta a questão
            $question->delete();
        }
        // agora lança os novos dados
        $dados = $req->all();
        $test->title = $dados['title'];
        $test->save();
        foreach ($dados['question'] as $q) {
            $question = new Question;
            $question->statement = $q['statement'];
            $test->questions()->save($question);
            $test->refresh();
            foreach ($q['answer'] as $a) {
                $answer = new Answer;
                $answer->option = $a['option'];
                $answer->isCorrect = isset($a['isCorrect']);
                $question->answers()->save($answer);
                $question->refresh();
            }
        }
        // tudo ok? redireciona
        return redirect()->route('test.index');
        
    }
    
    public function edit($id)
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        // se não é admin, redireciona
        if(!$isAdmin) return redirect()->route('test.index');
        // se é admin continuamos
        $test = Test::find($id);
        // mando o admin pq tem uma condicional no header
        return view('test.edit')
        ->with('test', $test)
        ->with('isAdmin', $isAdmin);
        
    }
    
    public function destroy($id)
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        // se não é admin, redireciona
        if(!$isAdmin) return redirect()->route('test.index');
        // se é admin continuamos
        $test = Test::find($id);
        $questions = $test->questions;
        foreach ($questions as $question) {
            $answers = $question->answers;
            foreach ($answers as $answer) {
                $answer->delete();
            }
            // depois de deletar cada resposta deleta a questão
            $question->delete();
        }
        $test->delete();
        // tudo ok? redireciona
        return redirect()->route('test.index');
        
    }
}
