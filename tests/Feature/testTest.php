<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

/**
 * Testa as rotas sem autenticação de usuário
 */
class testTest extends TestCase
{
    /**
     * Testa a requisição por um usuário não autenticado
     * @return void
     */
    public function test_getTestIndexForNoLoggedUser()
    {
        $response = $this->get(route('test.index'));
        // retorna ok e exibe a view correta
        $response->assertStatus(302);
        $response->assertLocation(route('login.index'));
    }

    /**
     * Testa a requisição por um usuário comum
     * @return void
     */
    public function test_getTestIndexForLoggedUser()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)
                        ->get(route('test.index'));
        // retorna ok e exibe a view correta
        $response->assertStatus(200);
        $response->assertViewIs('test.index');
        $response->assertViewHas('isAdmin', false);
    }

    /**
     * Testa a requisição por um usuário comum
     * @return void
     */
    public function test_getTestIndexForAdminUser()
    {
        $user = User::factory()->adminUser()->make();
        $response = $this->actingAs($user)
                        ->get(route('test.index'));
        // retorna ok e exibe a view correta
        $response->assertStatus(200);
        $response->assertViewIs('test.index');
        $response->assertViewHas('isAdmin', true);
    }
}