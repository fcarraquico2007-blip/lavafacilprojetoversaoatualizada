<?php
// processar_pedido.php
//
// Recebe o pedido feito em agendar.php e grava-o na tabela `servicos`.
// O preço é sempre RECALCULADO aqui no servidor (nunca se confia no
// valor que vem do browser, que pode ser alterado por qualquer pessoa).

header('Content-Type: application/json');
require_once 'conexao.php';
$config = require 'config_servicos.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (!$dados) {
    echo json_encode(['sucesso' => false, 'erro' => 'Pedido inválido.']);
    exit;
}

$idServico = (int)($dados['tipoServicoId'] ?? 0);

if (!isset($config[$idServico])) {
    echo json_encode(['sucesso' => false, 'erro' => 'Tipo de serviço inválido.']);
    exit;
}

$cfg = $config[$idServico];

// nomeCliente/contacto deixaram de vir do formulário (foram removidos
// a pedido). Ficam aqui só como aceitação opcional, para o caso de
// no futuro voltarem a ser pedidos noutro passo (ex: no pagamento).
$nomeCliente = trim($dados['nomeCliente'] ?? '');
$contacto    = trim($dados['contacto'] ?? '');
$kg          = (float)($dados['kg'] ?? 0);
$extras      = $dados['extras'] ?? 'Nenhum';
$recolha     = $dados['recolha'] ?? 'Loja';
$entrega     = $dados['entrega'] ?? 'Loja';
$localidade  = trim($dados['localidade'] ?? '');
$data        = $dados['data'] ?? '';
$hora        = $dados['hora'] ?? '';

// CORRIGIDO: nome/contacto já não são obrigatórios (foram removidos
// do formulário). Só validamos o que ainda existe no ecrã: data, hora
// e localidade.
if ($data === '' || $hora === '' || $localidade === '') {
    echo json_encode(['sucesso' => false, 'erro' => 'Faltam dados obrigatórios.']);
    exit;
}

if ($cfg['mostrar_kg'] && $kg <= 0) {
    echo json_encode(['sucesso' => false, 'erro' => 'Peso inválido.']);
    exit;
}

// --- Recalcular o preço no servidor ---
$preco = $cfg['mostrar_kg'] ? ($kg * $cfg['preco_kg']) : $cfg['preco_fixo'];

if ($cfg['mostrar_extras']) {
    if ($extras === 'Perfume') $preco += 1;
    if ($extras === 'Dobrar')  $preco += 1;
    if ($extras === 'Urgente') $preco += 3;
}

if ($cfg['mostrar_recolha_entrega']) {
    if ($recolha === 'Casa') $preco += 2;
    if ($entrega === 'Casa') $preco += 2;
}

// CORRIGIDO: como já não há nome/contacto no formulário, evitamos
// gravar uma coluna vazia. Se algum dia voltares a pedir o nome
// (ex: no ecrã de pagamento), isto volta a preenchê-lo automaticamente.
if ($nomeCliente !== '') {
    $nomeParaGuardar = $contacto !== '' ? "$nomeCliente ($contacto)" : $nomeCliente;
} else {
    $nomeParaGuardar = 'Cliente (agendamento online)';
}

$dataHoraPrevista = $data . ' ' . $hora . ':00';

try {
    $stmt = $pdo->prepare(
        "INSERT INTO servicos
            (data_hora_pedido, data_hora_prevista, nome_cliente, valor_servico, local, tipo_servico, estado, colaborador)
         VALUES
            (NOW(), ?, ?, ?, ?, ?, 1, NULL)"
        // estado = 1 -> 'Pendente' (ver tabela estados_pedidos)
    );

    $stmt->execute([
        $dataHoraPrevista,
        $nomeParaGuardar,
        $preco,
        $localidade,
        $idServico
    ]);

    $idPedido = $pdo->lastInsertId();

    echo json_encode([
        'sucesso' => true,
        'id_pedido' => $idPedido,
        'preco' => number_format($preco, 2, '.', '')
    ]);

} catch (\PDOException $e) {
    echo json_encode(['sucesso' => false, 'erro' => 'Erro ao gravar o pedido: ' . $e->getMessage()]);
}