# Objetos do banco

As functions, procedures e triggers ficam nesta pasta e são instaladas pela migration `create_objetos_banco`.
Basta rodar `php artisan migrate`. O `migrate:fresh` também instala tudo de novo.

Para testar no editor SQL do Neon, use o arquivo `testes_objetos.sql`.

## Aviso para o CRUD de pedidos

O estoque é controlado pela trigger `trg_controlar_estoque`. Não altere o estoque no código quando criar, editar ou excluir um item de pedido, porque a trigger já faz isso.

Os pedidos do seed foram carregados com as triggers desligadas, então eles nunca baixaram o estoque. Se um desses pedidos for excluído, a trigger devolve os produtos mesmo assim e o estoque fica maior do que deveria. Para a demonstração, exclua apenas pedidos criados pelo sistema.
