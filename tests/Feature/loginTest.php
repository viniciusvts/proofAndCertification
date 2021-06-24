<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

/**
 * Testa as rotas sem autenticação de usuário
 */
class loginTest extends TestCase
{
    /**
     * Testa a requisição por um usuário não autenticado
     * @return void
     */
    public function test_getLoginIndexForNoLoggedUser()
    {
        $response = $this->get(route('login.index'));
        // retorna ok e exibe a view correta
        $response->assertStatus(200);
        $response->assertViewIs('login.index');
    }
    
    /**
     * Testa a requisição autenticado por um usuário normal
     * @return void
     */
    public function test_getLoginIndexForLoggedUser()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)
                        ->get(route('login.index'));
        // caso o usuário esteja autenticado redireciona para a lista de testes
        $response->assertStatus(302);
        $response->assertLocation(route('test.index'));
    }
    
    /**
     * Testa a requisição autenticado por um usuário admin
     * @return void
     */
    public function test_getLoginIndexForAdminUser()
    {
        $user = User::factory()->adminUser()->make();
        $response = $this->actingAs($user)
                        ->get(route('login.index'));
        // caso o usuário esteja autenticado redireciona para a lista de testes
        $response->assertStatus(302);
        $response->assertLocation(route('test.index'));
    }
    
    /**
     * Testa a requisição de login com dados incorretos
     * @return void
     */
    public function test_postLoginWithCorrectData()
    {
        $user = User::factory()->create();
        $response = $this->post(route('login.entrar'),[
                                'email' => $user->email,
                                'senha' => 'password',
        ]);
        // caso o usuário esteja autenticado redireciona para a lista de testes
        $response->assertStatus(302);
        $response->assertLocation(route('test.index'));
        $this->assertAuthenticatedAs($user);
        // apaga o usuário criado para testes
        $user->delete();
        $this->assertDeleted($user);
    }
    
    /**
     * Testa a requisição de login sem dados
     * @return void
     */
    public function test_postLoginWithNoData()
    {
        $response = $this->post(route('login.entrar'));
        // sem informação? então bad request
        $response->assertStatus(400);
        $response->assertViewIs('login.index');
    }
    
    /**
     * Testa a requisição de login com dados aletórios
     * @return void
     */
    public function test_postLoginWithIncorrectData()
    {
        $response = $this->post(route('login.entrar'),[
                                'email' => 'testuser@testemail.com',
                                'senha' => 'password',
        ]);
        // dados incorretos? badrequest
        $response->assertStatus(400);
        $response->assertViewIs('login.index');
    }
    
    /**
     * Testa o logout
     *
     * @return void
     */
    public function test_getLoginSair()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)
                        ->get(route('login.sair'));
        // redireciona para página de login
        $response->assertStatus(302);
        $response->assertLocation(route('login.index'));
        $this->assertGuest();
        // na doc make() não cria user no banco como create(), mas aqui criou
        // provavelmente um bug, mas segue delete user
        $user->delete();
        $this->assertDeleted($user);
    }
}