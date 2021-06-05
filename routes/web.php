<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('login');
});
// login
Route::get('/login',[LoginController::class, 'index'])->name('login.index');
Route::post('/login',[LoginController::class, 'entrar'])->name('login.entrar');
Route::get('/login/sair',[LoginController::class, 'sair'])->name('login.sair');

Route::get('/testes',[TestController::class, 'test'])->name('test.index');
Route::post('/testes',[TestController::class, 'store'])->name('test.store');
Route::put('/testes/{id}',[TestController::class, 'update'])->name('test.update');
Route::get('/testes/novo',[TestController::class, 'create'])->name('test.create');
Route::get('/testes/{id}',[TestController::class, 'edit'])->name('test.edit');
Route::delete('/testes/{id}',[TestController::class, 'destroy'])->name('test.destroy');

// Route::group(['middleware'=>'auth'],function(){
    // Route::get('/tests/{test}', function (Test $test) {
    //     return $user->email;
    // });
//     Route::get('/admin/cursos',['as'=>'admin.cursos','uses'=>'Admin\CursoController@index']);
//     Route::get('/admin/cursos/adicionar',['as'=>'admin.cursos.adicionar','uses'=>'Admin\CursoController@adicionar']);
//     Route::post('/admin/cursos/salvar',['as'=>'admin.cursos.salvar','uses'=>'Admin\CursoController@salvar']);
//     Route::get('/admin/cursos/editar/{id}',['as'=>'admin.cursos.editar','uses'=>'Admin\CursoController@editar']);
//     Route::put('/admin/cursos/atualizar/{id}',['as'=>'admin.cursos.atualizar','uses'=>'Admin\CursoController@atualizar']);
//     Route::get('/admin/cursos/deletar/{id}',['as'=>'admin.cursos.deletar','uses'=>'Admin\CursoController@deletar']);
  
// });