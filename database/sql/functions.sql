-- mostra os produtos que mais venderam e quanto cada um faturou
create or replace function fn_produtos_mais_vendidos(p_limite int)
returns table (
    produto varchar,
    quantidade_vendida bigint,
    faturamento numeric
) as $$
begin
    return query
    select p.nome, sum(i.quantidade)::bigint, sum(i.quantidade * i.preco_unitario)
    from itens_pedido i
    join produto p on p.id_produto = i.produto_id
    group by p.id_produto, p.nome
    order by 2 desc
    limit p_limite;
end;
$$ language plpgsql;

-- mostra quantos pedidos o cliente fez, quanto já gastou e quando foi a última compra
-- o left join mantém na lista o cliente que ainda não comprou nada
create or replace function fn_resumo_cliente(p_cpf varchar)
returns table (
    nome_cliente varchar,
    total_pedidos bigint,
    total_gasto numeric,
    ultimo_pedido timestamp
) as $$
begin
    return query
    select c.nome, count(p.id_pedido), coalesce(sum(p.valor_total), 0), max(p.data_hora)::timestamp
    from cliente c
    left join pedido p on p.cliente_id = c.id_cliente
    where c.cpf = p_cpf
    group by c.id_cliente, c.nome;
end;
$$ language plpgsql;
