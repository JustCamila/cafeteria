-- registra uma venda com um ou mais produtos em um único pedido
-- o cpf é opcional, porque o cliente pode comprar sem se identificar
-- o preço vem do cadastro do produto, e se um item der erro a venda inteira é cancelada
create or replace procedure sp_registrar_venda(
    p_cpf varchar,
    p_forma_pagamento varchar,
    p_produtos bigint[],
    p_quantidades int[]
)
language plpgsql
as $$
declare
    v_cliente_id bigint;
    v_pedido_id bigint;
    v_preco numeric(10,2);
    v_total_itens int;
    i int;
begin
    v_total_itens := coalesce(array_length(p_produtos, 1), 0);

    if v_total_itens = 0 then
        raise exception 'informe pelo menos um produto.';
    end if;

    if v_total_itens <> coalesce(array_length(p_quantidades, 1), 0) then
        raise exception 'informe uma quantidade para cada produto.';
    end if;

    if p_cpf is not null then
        select id_cliente into v_cliente_id from cliente where cpf = p_cpf;

        if v_cliente_id is null then
            raise exception 'cliente com cpf % não foi encontrado.', p_cpf;
        end if;
    end if;

    insert into pedido (cliente_id, forma_pagamento)
    values (v_cliente_id, p_forma_pagamento)
    returning id_pedido into v_pedido_id;

    for i in 1..v_total_itens loop
        if p_quantidades[i] <= 0 then
            raise exception 'a quantidade deve ser maior que zero.';
        end if;

        select preco_unitario into v_preco from produto where id_produto = p_produtos[i];

        if v_preco is null then
            raise exception 'produto % não foi encontrado.', p_produtos[i];
        end if;

        insert into itens_pedido (pedido_id, produto_id, quantidade, preco_unitario)
        values (v_pedido_id, p_produtos[i], p_quantidades[i], v_preco);
    end loop;
end;
$$;

-- soma ao estoque os produtos que chegaram na cafeteria
create or replace procedure sp_repor_estoque(
    p_produto_id bigint,
    p_quantidade int
)
language plpgsql
as $$
begin
    if p_quantidade <= 0 then
        raise exception 'a quantidade deve ser maior que zero.';
    end if;

    update produto
    set estoque = estoque + p_quantidade
    where id_produto = p_produto_id;

    if not found then
        raise exception 'produto % não foi encontrado.', p_produto_id;
    end if;
end;
$$;
