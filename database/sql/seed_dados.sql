

-- ============================================================================
-- BLOCO 1: CATEGORIAS, PRODUTOS E DETALHES DOS CAFÉS
-- ============================================================================
DO $$
DECLARE
    v_id_cat_cafe           int;
    v_id_cat_acompanhamento int;

    v_nomes_cafe text[] := ARRAY[
        'Amanhecer Dourado', 'Vulcão Negro', 'Bruma da Serra',
        'Sinfonia Arábica', 'Terra Vermelha', 'Neblina Andina',
        'Ouro Torrado', 'Raiz da Montanha', 'Segredo do Cerrado',
        'Aurora Boreal do Café'
    ];
    v_descricoes_cafe text[] := ARRAY[
        'Blend suave com notas adocicadas e final aveludado',
        'Torra intensa e encorpada, ideal para expresso',
        'Café de altitude com acidez equilibrada',
        'Blend floral com toque frutado marcante',
        'Torra média, corpo redondo e final persistente',
        'Grãos selecionados de vale andino, doçura natural',
        'Torra escura, aroma de cacau e especiarias',
        'Café encorpado com notas terrosas e amadeiradas',
        'Blend do cerrado mineiro, equilibrado e cremoso',
        'Edição especial com notas cítricas e florais'
    ];
    v_origem_grao text[] := ARRAY[
        'Sul de Minas - Brasil', 'Cerrado Mineiro - Brasil', 'Huila - Colômbia',
        'Yirgacheffe - Etiópia', 'Mogiana - Brasil', 'Huehuetenango - Guatemala',
        'Tarrazú - Costa Rica', 'Sumatra - Indonésia', 'Nyeri - Quênia',
        'Chapada de Minas - Brasil'
    ];
    v_notas_degustacao text[] := ARRAY[
        'Caramelo', 'Chocolate amargo', 'Morango', 'Laranja',
        'Amêndoas', 'Mel', 'Frutas vermelhas', 'Floral',
        'Especiarias', 'Cítrico'
    ];
    v_tipo_torra text[] := ARRAY[
        'Média', 'Forte', 'Clara', 'Média', 'Forte',
        'Clara', 'Forte', 'Média', 'Média', 'Clara'
    ];
    v_estoque_cafe int[] := ARRAY[45, 30, 0, 60, 2, 25, 80, 1, 50, 20];
    v_preco_cafe decimal(10,2)[] := ARRAY[24.90, 27.50, 22.00, 29.90, 21.50, 26.00, 32.00, 23.50, 25.90, 34.90];

    v_nomes_acomp text[] := ARRAY[
        'Cookie de Gotas de Chocolate', 'Croissant Amanteigado',
        'Muffin de Blueberry', 'Pão de Mel Artesanal',
        'Brownie de Nozes', 'Torta de Limão Individual',
        'Scone de Frutas Vermelhas', 'Bolo de Cenoura com Cobertura',
        'Biscoito Amanteigado', 'Pão de Queijo Gourmet'
    ];
    v_descricoes_acomp text[] := ARRAY[
        'Cookie artesanal recheado com gotas de chocolate belga',
        'Croissant folhado, amanteigado e crocante',
        'Muffin fofinho com mirtilos frescos',
        'Pão de mel coberto com chocolate meio amargo',
        'Brownie úmido com nozes crocantes',
        'Torta individual com creme de limão siciliano',
        'Scone macio recheado com frutas vermelhas',
        'Fatia de bolo de cenoura com cobertura de chocolate',
        'Biscoito amanteigado tradicional',
        'Pão de queijo artesanal servido quentinho'
    ];
    v_preco_acomp decimal(10,2)[] := ARRAY[8.50, 9.90, 10.50, 7.90, 11.00, 12.50, 9.50, 10.90, 6.50, 8.00];
    v_estoque_acomp int[] := ARRAY[40, 35, 0, 55, 2, 30, 45, 1, 60, 25];

    i int;
    v_produto_id int;
BEGIN
    INSERT INTO categoria (nome) VALUES ('Cafés Gourmet')
        RETURNING id_categoria INTO v_id_cat_cafe;
    INSERT INTO categoria (nome) VALUES ('Acompanhamento')
        RETURNING id_categoria INTO v_id_cat_acompanhamento;

    FOR i IN 1..10 LOOP
        INSERT INTO produto (categoria_id, nome, descricao, preco_unitario, estoque)
        VALUES (v_id_cat_cafe, v_nomes_cafe[i], v_descricoes_cafe[i], v_preco_cafe[i], v_estoque_cafe[i])
        RETURNING id_produto INTO v_produto_id;

        INSERT INTO detalhe_cafe (produto_id, origem_grao, notas_degustacao, tipo_torra)
        VALUES (v_produto_id, v_origem_grao[i], v_notas_degustacao[i], v_tipo_torra[i]);
    END LOOP;

    FOR i IN 1..10 LOOP
        INSERT INTO produto (categoria_id, nome, descricao, preco_unitario, estoque)
        VALUES (v_id_cat_acompanhamento, v_nomes_acomp[i], v_descricoes_acomp[i], v_preco_acomp[i], v_estoque_acomp[i]);
    END LOOP;
END $$;


-- ============================================================================
-- BLOCO 2: 15.000 CLIENTES
-- ============================================================================
DO $$
DECLARE
    v_primeiros_nomes text[] := ARRAY[
        'Miguel','Arthur','Bernardo','Heitor','Davi','Lorenzo','Theo','Pedro',
        'Gabriel','Samuel','Enzo','Lucas','Matheus','Rafael','Guilherme','Bryan',
        'Erick','Nicolas','Vinicius','Gustavo','Julia','Sophia','Manuela','Alice',
        'Laura','Isabella','Maria','Helena','Valentina','Heloisa','Luiza','Cecilia',
        'Beatriz','Elisa','Sarah','Lorena','Livia','Antonella','Maite','Yasmin',
        'Fernanda','Camila','Amanda','Bruna','Larissa','Patricia','Renata','Vanessa',
        'Carla','Andre'
    ];
    v_sobrenomes text[] := ARRAY[
        'Silva','Santos','Oliveira','Souza','Rodrigues','Ferreira','Alves','Pereira',
        'Lima','Gomes','Costa','Ribeiro','Martins','Carvalho','Almeida','Lopes',
        'Soares','Fernandes','Vieira','Barbosa','Rocha','Dias','Nascimento','Andrade',
        'Moreira','Nunes','Marques','Machado','Mendes','Freitas','Cardoso','Ramos',
        'Goncalves','Santana','Teixeira','Correia','Cavalcanti','Monteiro','Moura','Araujo',
        'Reis','Castro','Campos','Cunha','Pinto','Azevedo','Melo','Farias',
        'Batista','Duarte','Guimaraes','Xavier','Peixoto','Assis','Lacerda','Tavares',
        'Siqueira','Bastos','Vasconcelos','Pimentel'
    ];
    v_primeiro  text;
    v_sobrenome text;
    v_telefone  varchar(11);
    i int;
BEGIN
    FOR i IN 1..15000 LOOP
        v_primeiro  := v_primeiros_nomes[1 + floor(random() * array_length(v_primeiros_nomes, 1))::int];
        v_sobrenome := v_sobrenomes[1 + floor(random() * array_length(v_sobrenomes, 1))::int];

        v_telefone := LPAD((10 + floor(random() * 90))::int::text, 2, '0')
                      || '9' || LPAD(floor(random() * 100000000)::int::text, 8, '0');

        INSERT INTO cliente (cpf, nome, telefone, email)
        VALUES (
            LPAD(i::text, 11, '0'),
            v_primeiro || ' ' || v_sobrenome,
            v_telefone,
            lower(v_primeiro) || '.' || lower(v_sobrenome) || i::text || '@gmail.com'
        );
    END LOOP;
END $$;


-- ============================================================================
-- BLOCO 3: 15.000 PEDIDOS + ITENS
--   * clientes 1..1500 nunca compram (clientes inativos);
--   * 'Raiz da Montanha' e 'Torta de Limão Individual' nunca são vendidos.
-- ============================================================================
DO $$
DECLARE
    v_pedido_id   int;
    v_cliente_id  int;
    v_produto_id  int;
    v_preco       decimal(10,2);
    v_quantidade  int;
    v_valor_total decimal(10,2);
    v_qtd_itens   int;
    v_formas_pagamento text[] := ARRAY['Cartão de Crédito','Cartão de Débito','Pix','Dinheiro'];

    v_min_produto int;
    v_max_produto int;
    v_id_cafe_encalhado int;
    v_id_acomp_encalhado int;
    i int;
    j int;
BEGIN
    SELECT min(id_produto), max(id_produto) INTO v_min_produto, v_max_produto FROM produto;
    SELECT id_produto INTO v_id_cafe_encalhado  FROM produto WHERE nome = 'Raiz da Montanha';
    SELECT id_produto INTO v_id_acomp_encalhado FROM produto WHERE nome = 'Torta de Limão Individual';

    FOR i IN 1..15000 LOOP
        v_cliente_id := 1501 + floor(random() * (15000 - 1501 + 1))::int;

        INSERT INTO pedido (cliente_id, data_hora, forma_pagamento, valor_total)
        VALUES (
            v_cliente_id,
            now() - (floor(random() * 730) || ' days')::interval
                  - (floor(random() * 86400) || ' seconds')::interval,
            v_formas_pagamento[1 + floor(random() * 4)::int],
            0
        )
        RETURNING id_pedido INTO v_pedido_id;

        v_valor_total := 0;
        v_qtd_itens := 1 + floor(random() * 3)::int;

        FOR j IN 1..v_qtd_itens LOOP
            LOOP
                v_produto_id := v_min_produto + floor(random() * (v_max_produto - v_min_produto + 1))::int;
                EXIT WHEN v_produto_id NOT IN (v_id_cafe_encalhado, v_id_acomp_encalhado);
            END LOOP;

            SELECT preco_unitario INTO v_preco FROM produto WHERE id_produto = v_produto_id;
            v_quantidade := 1 + floor(random() * 3)::int;

            INSERT INTO itens_pedido (produto_id, pedido_id, quantidade, preco_unitario)
            VALUES (v_produto_id, v_pedido_id, v_quantidade, v_preco);

            v_valor_total := v_valor_total + (v_quantidade * v_preco);
        END LOOP;

        UPDATE pedido SET valor_total = v_valor_total WHERE id_pedido = v_pedido_id;
    END LOOP;
END $$;