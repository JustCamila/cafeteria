<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Produto;
use Tests\BancoTestCase;

class ProdutoWebTest extends BancoTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_listagem_de_produtos_retorna_200_e_mostra_o_produto(): void
    {
        Produto::create([
            'nome' => 'Espresso Teste',
            'descricao' => 'Cafe curto e intenso',
            'preco_unitario' => 8.50,
            'estoque' => 10,
        ]);

        $this->get('/produtos')
            ->assertOk()
            ->assertSee('Espresso Teste');
    }

    public function test_cadastro_de_produto_redireciona_e_grava_no_banco(): void
    {
        $categoria = Categoria::create(['nome' => 'Bebidas Teste']);

        $resposta = $this->post('/produtos', [
            'categoria_id' => $categoria->id_categoria,
            'nome' => 'Cappuccino Teste',
            'descricao' => 'Cafe com leite vaporizado',
            'preco_unitario' => '12,50',
            'estoque' => 5,
        ]);

        $this->assertDatabaseHas('produto', [
            'nome' => 'Cappuccino Teste',
            'categoria_id' => $categoria->id_categoria,
        ]);

        $produto = Produto::where('nome', 'Cappuccino Teste')->firstOrFail();
        $resposta->assertRedirect(route('produtos.show', $produto));
    }
}