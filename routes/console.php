<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('make:adminuser', function () {
    // solicita no console dados para o novo user
    $email = $this->ask('Digite um e-mail');
    $name = $this->ask('Digite o nome');
    $password = $this->secret('Digite a senha');
    // procura no banco  se já tem email cadastrado
    // caso negativo cria um novo
    $user = App\Models\User::firstOrNew(['email' => $email]);
    
    $user->fill([
        'name' => $name, 
        'password' => bcrypt($password),
        'type' => 'admin',
    ])->save();
    
    $this->info('Usuário criado/atualizado com sucesso');
    
})->describe('Cria um usuário pela linha de comando');

Artisan::command('make:user', function () {
    // solicita no console dados para o novo user
    $email = $this->ask('Digite um e-mail');
    $name = $this->ask('Digite o nome');
    $password = $this->secret('Digite a senha');
    // procura no banco  se já tem email cadastrado
    // caso negativo cria um novo
    $user = App\Models\User::firstOrNew(['email' => $email]);
    
    $user->fill([
        'name' => $name, 
        'password' => bcrypt($password),
        'type' => 'user',
    ])->save();
    
    $this->info('Usuário criado/atualizado com sucesso');
    
})->describe('Cria um usuário pela linha de comando');