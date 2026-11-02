create or replace function fn_baixar_estoque()
returns trigger as $$
declare
    v_nome varchar;
    v_estoque int;
begin
    select nome, estoque into v_nome, v_estoque
    from produto
    where id_produto = new.produto_id
    for update;

    if v_estoque < new.quantidade then
        raise exception 'estoque insuficiente de %: disponível %, pedido %.', v_nome, v_estoque, new.quantidade;
    end if;

    update produto
    set estoque = estoque - new.quantidade
    where id_produto = new.produto_id;

    return new;
end;
$$ language plpgsql;

drop trigger if exists trg_baixar_estoque on itens_pedido;
create trigger trg_baixar_estoque
before insert on itens_pedido
for each row
execute function fn_baixar_estoque();

create or replace function fn_atualizar_valor_total()
returns trigger as $$
declare
    v_pedido_id bigint;
begin
    if tg_op = 'DELETE' then
        v_pedido_id := old.pedido_id;
    else
        v_pedido_id := new.pedido_id;
    end if;

    update pedido
    set valor_total = (
        select coalesce(sum(quantidade * preco_unitario), 0)
        from itens_pedido
        where pedido_id = v_pedido_id
    )
    where id_pedido = v_pedido_id;

    return null;
end;
$$ language plpgsql;

drop trigger if exists trg_atualizar_valor_total on itens_pedido;
create trigger trg_atualizar_valor_total
after insert or update or delete on itens_pedido
for each row
execute function fn_atualizar_valor_total();
