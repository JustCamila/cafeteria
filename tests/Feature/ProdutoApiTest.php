<?php

namespace Tests\Feature;

use App\Models\Produto;
use Tests\BancoTestCase;

class ProdutoApiTest extends BancoTestCase
{
    private function criarProduto(string $nome = 'Mocha Teste'): Produto
    {
        return Produto::create([
            'nome' => $nome,
            'descricao' => 'Cafe com chocolate',
            'preco_unitario' => 14.00,
            'estoque' => 7,
        ]);
    }

    public function test_get_api_produtos_retorna_200_com_a_estrutura_esperada(): void
    {
        $this->criarProduto();

        $this->getJson('/api/produtos')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'nome', 'descricao', 'preco_unitario', 'estoque'],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_post_api_produtos_cria_produto_e_retorna_201(): void
    {
        $this->postJson('/api/produtos', [
            'nome' => 'Latte Teste',
            'descricao' => 'Cafe com bastante leite',
            'preco_unitario' => 13.90,
            'estoque' => 4,
        ])
            ->assertCreated()
            ->assertJsonStructure([
                'data' => ['id', 'nome', 'descricao', 'preco_unitario', 'estoque'],
            ])
            ->assertJsonPath('data.nome', 'Latte Teste');

        $this->assertDatabaseHas('produto', ['nome' => 'Latte Teste']);
    }

    public function test_post_api_produtos_com_dados_invalidos_retorna_422(): void
    {
        $this->postJson('/api/produtos', [
            'nome' => '',
            'preco_unitario' => -5,
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['nome', 'descricao', 'preco_unitario']);
    }

    public function test_get_api_produto_inexistente_retorna_404(): void
    {
        $this->getJson('/api/produtos/999999')->assertNotFound();
    }

    public function test_delete_api_produto_retorna_204_e_remove_do_banco(): void
    {
        $produto = $this->criarProduto('Para Excluir');

        $this->deleteJson("/api/produtos/{$produto->id_produto}")->assertNoContent();

        $this->assertDatabaseMissing('produto', ['id_produto' => $produto->id_produto]);
    }
}