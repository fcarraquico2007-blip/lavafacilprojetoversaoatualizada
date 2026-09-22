<?php
/**
 * registar.php
 * Cria uma nova conta de cliente na tabela "clientes".
 * Contas de admin não são criadas por aqui (ver tabela "admins").
 */

session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
    exit;
}

$nome  = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass  = $_POST['pass'] ?? '';
$cpass = $_POST['cpass'] ?? '';

// --- Validação no servidor ---
$erros = [];

if ($nome === '') {
    $erros[] = 'O nome é obrigatório.';
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'Indica um email válido.';
}

if (strlen($pass) < 6) {
    $erros[] = 'A palavra-passe deve ter pelo menos 6 caracteres.';
}

if ($pass !== $cpass) {
    $erros[] = 'As palavras-passe não coincidem.';
}

if (!empty($erros)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $erros)]);
    exit;
}

// --- Verifica se já existe este email em clientes OU em admins ---
$stmt = $pdo->prepare('SELECT id FROM clientes WHERE email = ?');
$stmt->execute([$email]);

if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Já existe uma conta com este email.']);
    exit;
}

$stmt = $pdo->prepare('SELECT id FROM admins WHERE email = ?');
$stmt->execute([$email]);

if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Já existe uma conta com este email.']);
    exit;
}

// --- Cria o cliente ---
$hash = password_hash($pass, PASSWORD_DEFAULT);

// tipo_cliente = 1 ("Particular") por defeito, qtd_pedidos e total_gasto a 0
$stmt = $pdo->prepare(
    'INSERT INTO clientes (nome, email, password, tipo_cliente, qtd_pedidos, total_gasto, pontos_fidelidade)
     VALUES (?, ?, ?, 1, 0, 0, 0)'
);
$stmt->execute([$nome, $email, $hash]);

echo json_encode([
    'success' => true,
    'message' => 'Conta criada com sucesso! Podes agora iniciar sessão.'
]);
