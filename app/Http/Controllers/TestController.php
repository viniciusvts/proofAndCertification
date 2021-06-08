<?php

namespace App\Http\Controllers;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;

use Illuminate\Http\Request;
use Auth;

class TestController extends Controller
{
    public function index()
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $tests = Test::paginate(10);
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        return view('test.index')
            ->with('user', $user)
            ->with('tests', $tests)
            ->with('isAdmin', $isAdmin);
    }
    
    public function create()
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        if($isAdmin){
            return view('test.create')
            ->with('isAdmin', $isAdmin);;
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
        $test->time_to_finish = $dados['time_to_finish'];
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
        $test->time_to_finish = $dados['time_to_finish'];
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
    
    public function dotest($id)
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        if($isAdmin) return redirect()->route('test.index');

        // já fez o teste antes?
        $test = $user->tests()->find($id);
        if($test){
            // verifica se já fez o teste em menos de 24h
            $lastAttempt = $test->pivot->updated_at->getTimestamp();
            $atualDte = date('Y-m-d H:i:s');
            $diferencaEntreDatasEmSegundos = strtotime($atualDte) - $lastAttempt;
            $oneDayInSeconds = (60*60*24);
            $diferenceInDays = $diferencaEntreDatasEmSegundos/$oneDayInSeconds;
            // se a diferença entre as datas é menor que um dia (24h) exibir uma mensagem
            if ($diferenceInDays < 1){
                return view('message')
                ->with('isAdmin', $isAdmin)
                ->with('message', 'Você tem de esperar 24h para tentar novamente');
            }
        }

        $test = Test::find($id);
        return view('test.dotest')
        ->with('test', $test)
        ->with('questionPerPage', 5)
        ->with('user', $user)
        ->with('isAdmin', $isAdmin);
    }
    
    public function checkResults(Request $req, $id)
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        if($isAdmin) return redirect()->route('test.index');

        $dados = $req->all();
        // já fez o teste antes?
        $test = $user->tests()->find($id);
        if($test){
            // verifica se já fez o teste em menos de 24h
            $lastAttempt = $test->pivot->updated_at->getTimestamp();
            $atualDte = date('Y-m-d H:i:s');
            $diferencaEntreDatasEmSegundos = strtotime($atualDte) - $lastAttempt;
            $oneDayInSeconds = (60*60*24);
            $diferenceInDays = $diferencaEntreDatasEmSegundos/$oneDayInSeconds;
            // se a diferença entre as datas é menor que um dia (24h) exibir uma mensagem
            if ($diferenceInDays < 1){
                return view('message')
                ->with('isAdmin', $isAdmin)
                ->with('message', 'Você tem de esperar 24h para tentar novamente');
            }
        }
        // remove o token das respostas
        unset($dados['_token']);
        // conta quantas questões certas
        $questionsReceived = count($dados);
        $questionsCorrect = 0;
        foreach ($dados as $resp) {
            $answer = Answer::find($resp);
            if ($answer->isCorrect == 1){
                $questionsCorrect++;
            }
        }
        // verifica a percentagem de questões certas
		$result = ($questionsCorrect / $questionsReceived) * 100;
        // se passou
		if($result >= 80){
            // se já fez o teste anteriormente atualiza a informação e pega a nova data
            // se não fez anteriormente, salva a nova informação
            if ($test){
                $user->tests()->updateExistingPivot($id, ['is_approved' => true]);
            } else {
                $test = Test::find($id);
                $user->tests()->attach($test, ['is_approved' => true]);
            }
        } else {
            // no caso de já ter feito o teste não atualiza, o certificado vai ser gerado com a data antiga
            if (!$test){
                $test = Test::find($id);
                $user->tests()->attach($test, [
                    'is_approved' => false,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            return view('message')
            ->with('isAdmin', $isAdmin)
            ->with('message', 'Você não foi aprovado! Nota: ' . round($result, 2));
        }
        return redirect()->route('test.getCertificate', ['id' => $id]);
    }

    function getCertificate($id)
    {
        if(!Auth::check()) return redirect()->route('login.index');
        $user = Auth::user();
        $isAdmin = $user->type == 'admin';
        if($isAdmin) return redirect()->route('test.index');
        
        $test = $user->tests()->find($id);
        $lastAttempt = $test->pivot->updated_at->getTimestamp();
        $basepath = base_path();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->AddPage('L');
        $stylesheet = file_get_contents($basepath . '/resources/certificate/style.css');
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $html = '
            <h1 style="margin-collapse: none; margin-top: 80mm; text-align: center">'.
            strtoupper($user->name).'</h1>
            <h2 style="margin-collapse: none; margin-top: 14mm; text-align: center">'.
            $test->title.'</h2>'.
            '<h2 style="margin-collapse: none; margin-top: 15mm; text-align: center">'.
            date("d/m/Y", $lastAttempt).'</h2>
        ';
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->SetTitle($test->title);
        return $mpdf->Output('certificado-dna-de-vendas.pdf',"I");
    }
}
