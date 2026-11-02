select * from fn_produtos_mais_vendidos(5);

select * from fn_resumo_cliente('00000002000');

select estoque from produto where id_produto = 1;

call sp_registrar_venda('00000002000', 'Pix', 1, 2);

select estoque from produto where id_produto = 1;

select * from pedido order by id_pedido desc limit 1;

select * from itens_pedido order by id_itens_pedido desc limit 1;

call sp_repor_estoque(1, 10);

select estoque from produto where id_produto = 1;

call sp_registrar_venda(null, 'Pix', 3, 1);
