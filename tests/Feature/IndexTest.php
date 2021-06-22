<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

/**
 * Testa as rotas sem autenticação de usuário
 */
class IndexTest extends TestCase
{
    /**
     * Testa a requisição por um usuário não autenticado
     * @return void
     */
    public function test_noLoggedUserRedirectsToLogin()
    {
        $response = $this->get(route('index'));
        // essa rota redireciona para login
        $response->assertStatus(302);
        $response->assertLocation(route('login.index'));
    }
    
    /**
     * Testa a requisição autenticado por um usuário normal
     * @return void
     */
    public function test_loggedUserRedirectsToLogin()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)
                        ->get(route('index'));
        // essa rota redireciona para login
        $response->assertStatus(302);
        $response->assertLocation(route('login.index'));
    }
    
    /**
     * Testa a requisição autenticado por um usuário admin
     * @return void
     */
    public function test_loggedAdminRedirectsToLogin()
    {
        $user = User::factory()->adminUser()->make();
        $response = $this->actingAs($user)
                        ->get(route('index'));
        // essa rota redireciona para login
        $response->assertStatus(302);
        $response->assertLocation(route('login.index'));
    }
}