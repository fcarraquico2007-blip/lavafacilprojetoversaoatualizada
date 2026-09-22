<?php
// confirmar_pagamento.php
// Chamado pelo pagamento.js depois do pagamento online simulado.
// Muda o estado do pedido de 1 (Pendente) para 2 (Aceite) — ver a
// tabela estados_pedidos para a lista completa de estados.

header('Content-Type: application/json');
require_once 'conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo json_encode(['sucesso' => false, 'erro' => 'Pedido inválido.']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE servicos SET estado = 2 WHERE id_servico = ?");
    $stmt->execute([$id]);

    echo json_encode(['sucesso' => true]);
} catch (\PDOException $e) {
    echo json_encode(['sucesso' => false, 'erro' => 'Erro ao confirmar pagamento: ' . $e->getMessage()]);
}
