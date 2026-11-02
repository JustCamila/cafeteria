-- teste das functions
select * from fn_produtos_mais_vendidos(5);

select * from fn_resumo_cliente('00000002000');

-- venda com dois produtos: o estoque baixa e o total do pedido é calculado
select id_produto, estoque from produto where id_produto in (1, 2) order by id_produto;

call sp_registrar_venda('00000002000', 'Pix', '{1,2}', '{2,1}');

select id_produto, estoque from produto where id_produto in (1, 2) order by id_produto;

select * from pedido order by id_pedido desc limit 1;

select * from itens_pedido order by id_itens_pedido desc limit 2;

-- editar a quantidade de um item ajusta o estoque e o total
update itens_pedido
set quantidade = 3
where id_itens_pedido = (select max(id_itens_pedido) from itens_pedido);

select id_produto, estoque from produto where id_produto in (1, 2) order by id_produto;

select * from pedido order by id_pedido desc limit 1;

-- excluir o pedido devolve os produtos ao estoque
delete from pedido where id_pedido = (select max(id_pedido) from pedido);

select id_produto, estoque from produto where id_produto in (1, 2) order by id_produto;

-- reposição de estoque
call sp_repor_estoque(1, 10);

select estoque from produto where id_produto = 1;

-- esse dá erro de propósito: o produto 3 está sem estoque
call sp_registrar_venda(null, 'Pix', '{3}', '{1}');
