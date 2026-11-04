SELECT current_database() AS banco;
SELECT 'categoria' AS tabela, count(*) FROM categoria
UNION ALL SELECT 'cliente', count(*) FROM cliente
UNION ALL SELECT 'produto', count(*) FROM produto
UNION ALL SELECT 'detalhe_cafe', count(*) FROM detalhe_cafe
UNION ALL SELECT 'pedido', count(*) FROM pedido
UNION ALL SELECT 'itens_pedido', count(*) FROM itens_pedido;