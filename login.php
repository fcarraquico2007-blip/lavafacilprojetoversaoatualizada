<?php
/**
 * login.php
 * Autentica o utilizador. Procura primeiro em "admins", depois em "clientes".
 */

session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$pass  = $_POST['pass'] ?? '';

if ($email === '' || $pass === '') {
    echo json_encode(['success' => false, 'message' => 'Preenche o email e a palavra-passe.']);
    exit;
}

$role = null;
$user = null;

// --- 1) Tenta encontrar como admin ---
$stmt = $pdo->prepare('SELECT * FROM admins WHERE email = ?');
$stmt->execute([$email]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($pass, $admin['password'])) {
    $user = $admin;
    $role = 'admin';
}

// --- 2) Se não for admin, tenta como cliente ---
if (!$user) {
    $stmt = $pdo->prepare('SELECT * FROM clientes WHERE email = ?');
    $stmt->execute([$email]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente && !empty($cliente['password']) && password_verify($pass, $cliente['password'])) {
        $user = $cliente;
        $role = 'cliente';
    }
}

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Email ou palavra-passe incorretos.']);
    exit;
}

// --- Cria a sessão ---
session_regenerate_id(true); // proteção contra fixação de sessão

$idField = $role === 'admin' ? 'id' : 'id'; // ambas as tabelas usam "id" como PK

$_SESSION['user_id'] = $user[$idField];
$_SESSION['nome']    = $user['nome'];
$_SESSION['email']   = $user['email'];
$_SESSION['role']    = $role; // 'admin' ou 'cliente'

echo json_encode([
    'success'  => true,
    'message'  => 'Sessão iniciada com sucesso!',
    'role'     => $role,
    'redirect' => 'agendar.php'
]);

