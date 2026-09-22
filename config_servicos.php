<?php
// config_servicos.php
// As chaves (1-10) TÊM de corresponder exatamente ao cod_tiposervico
// da tabela `tipos_servicos`:
//   1 Lavagem | 2 Secagem | 3 Engomadoria | 4 Recolha em casa
//   5 Entrega em casa | 6 Pack Lavagem+Secagem | 7 Pack Lavagem+Secagem+Ferro
//   8 Pack Mensal Pequeno | 9 Pack Mensal Médio | 10 Pack Mensal Grande
//
// Só o preço da Lavagem (3.5€/Kg) é real. Os restantes são exemplos —
// ajusta aos preços reais do teu negócio.

return [

    1 => [ // Lavagem
        'mostrar_kg' => true,
        'preco_kg' => 3.5,
        'preco_fixo' => 0,
        'mostrar_extras' => true,
        'mostrar_recolha_entrega' => true,
    ],

    2 => [ // Secagem
        'mostrar_kg' => true,
        'preco_kg' => 2.5,
        'preco_fixo' => 0,
        'mostrar_extras' => true,
        'mostrar_recolha_entrega' => true,
    ],

    3 => [ // Engomadoria
        'mostrar_kg' => true,
        'preco_kg' => 4.0,
        'preco_fixo' => 0,
        'mostrar_extras' => true,
        'mostrar_recolha_entrega' => true,
    ],

    4 => [ // Recolha em casa
        'mostrar_kg' => false,
        'preco_kg' => 0,
        'preco_fixo' => 2.0,
        'mostrar_extras' => false,
        'mostrar_recolha_entrega' => false,
    ],

    5 => [ // Entrega em casa
        'mostrar_kg' => false,
        'preco_kg' => 0,
        'preco_fixo' => 2.0,
        'mostrar_extras' => false,
        'mostrar_recolha_entrega' => false,
    ],

    6 => [ // Pack Lavagem + Secagem
        'mostrar_kg' => true,
        'preco_kg' => 5.5,
        'preco_fixo' => 0,
        'mostrar_extras' => true,
        'mostrar_recolha_entrega' => true,
    ],

    7 => [ // Pack Lavagem + Secagem + Ferro
        'mostrar_kg' => true,
        'preco_kg' => 8.5,
        'preco_fixo' => 0,
        'mostrar_extras' => true,
        'mostrar_recolha_entrega' => true,
    ],

    8 => [ // Pack Mensal Pequeno (<10 Kg/mês)
        'mostrar_kg' => false,
        'preco_kg' => 0,
        'preco_fixo' => 35.0,
        'mostrar_extras' => false,
        'mostrar_recolha_entrega' => true,
    ],

    9 => [ // Pack Mensal Médio (10-20 Kg/mês)
        'mostrar_kg' => false,
        'preco_kg' => 0,
        'preco_fixo' => 60.0,
        'mostrar_extras' => false,
        'mostrar_recolha_entrega' => true,
    ],

    10 => [ // Pack Mensal Grande (>20 Kg/mês)
        'mostrar_kg' => false,
        'preco_kg' => 0,
        'preco_fixo' => 95.0,
        'mostrar_extras' => false,
        'mostrar_recolha_entrega' => true,
    ],

];
