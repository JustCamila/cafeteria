<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;

abstract class BancoTestCase extends TestCase
{
    use RefreshDatabase;

    // roda antes do migrate:fresh: se não for o banco de testes, aborta
    protected function beforeRefreshingDatabase(): void
    {
        $conexao = config('database.default');
        $banco = config("database.connections.{$conexao}.database");

        if ($banco !== 'cafeteria_testes') {
            throw new RuntimeException("Teste abortado: o banco '{$banco}' não é o de testes.");
        }
    }
}